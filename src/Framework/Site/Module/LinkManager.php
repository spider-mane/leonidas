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
        $enabled = $this->enabledLinks();

        foreach ($this->links() as $link => $args) {
            if (!in_array($link, $enabled)) {
                $callback = $args[0];
                $priority = $args[1] ?? 10;

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

    protected function enabledLinks(): array
    {
        return $this->getConfig('view.links', []);
    }
}
