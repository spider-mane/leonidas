<?php

namespace Leonidas\Framework\Site\Module;

use Closure;
use Leonidas\Framework\Module\Abstracts\Module;
use Leonidas\Hooks\TargetsInitHook;

class EmbedDisabler extends Module
{
    use TargetsInitHook;

    public function hook(): void
    {
        $this->targetInitHook();
    }

    protected function doInitAction(): void
    {
        $this->disableEmbeds();
    }

    /**
     * Disable WP embeds
     */
    protected function disableEmbeds(): void
    {
        // Remove the REST API endpoint.
        remove_action('rest_api_init', 'wp_oembed_register_route');

        // Turn off oEmbed auto discovery.
        add_filter('embed_oembed_discover', '__return_false');

        // Don't filter oEmbed results.
        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

        // Remove oEmbed discovery links.
        remove_action('wp_head', 'wp_oembed_add_discovery_links');

        // Remove oEmbed-specific JavaScript from the front-end and back-end.
        remove_action('wp_head', 'wp_oembed_add_host_js');
        add_filter('tiny_mce_plugins', Closure::fromCallable([$this, 'disableEmbedsTinyMcePlugin']));

        // Remove all embeds rewrite rules.
        add_filter('rewrite_rules_array', Closure::fromCallable([$this, 'disableEmbedsRewrites']));

        // Remove filter of the oEmbed result before any HTTP requests are made.
        remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);
    }

    protected function disableEmbedsTinyMcePlugin(array $plugins): array
    {
        return array_diff($plugins, ['wpembed']);
    }

    protected function disableEmbedsRewrites($rules)
    {
        foreach ($rules as $rule => $rewrite) {
            if (false !== strpos($rewrite, 'embed=true')) {
                unset($rules[$rule]);
            }
        }

        return $rules;
    }
}
