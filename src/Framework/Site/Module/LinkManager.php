<?php

namespace Leonidas\Framework\Site\Module;

use Leonidas\Framework\Module\Abstracts\Module;
use Leonidas\Hooks\TargetsInitHook;

class LinkManager extends Module
{
    use TargetsInitHook;

    public function hook(): void
    {
        $this->targetInitHook();
    }

    protected function doInitAction(): void
    {
        $enabled = $this->enabledTags();

        foreach ($this->links() as $tag => $args) {
            if (!in_array($tag, $enabled)) {
                $callback = $args[0];
                $priority = $args[1] ?? HOOK_DEFAULT_PRIORITY;

                remove_action('wp_head', $callback, $priority);
            }
        }
    }

    protected function links(): array
    {
        return [
            'adjacent_posts' => ['adjacent_posts_rel_link_wp_head'],
            'canonical' => ['rel_canonical'],
            'generator' => ['wp_generator'],
            'rsd' => ['rsd_link'],
            'shortlink' => ['wp_shortlink_wp_head'],
            'wlwmanifest' => ['wlwmanifest_link'],
        ];
    }

    protected function enabledTags(): array
    {
        return $this->getConfig('view.links', []);
    }
}
