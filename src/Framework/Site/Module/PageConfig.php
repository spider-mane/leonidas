<?php

namespace Leonidas\Framework\Site\Module;

use Leonidas\Framework\Module\Abstracts\Module;
use Leonidas\Hooks\TargetsAllowedBlockTypesAllHook;
use WP_Block_Editor_Context;

class PageConfig extends Module
{
    use TargetsAllowedBlockTypesAllHook;

    public function hook(): void
    {
        $this->targetAllowedBlockTypesAllHook();
    }

    protected function allowedBlockTypesAllPriority(): int
    {
        return PHP_INT_MAX;
    }

    protected function filterAllowedBlockTypesAll($allowed, WP_Block_Editor_Context $context)
    {
        $pages = $this->pages();
        $post = $context->post;

        if (!$pages || !$post || 'page' !== $post->post_type) {
            return $allowed;
        }

        return $pages[$post->post_name]['blocks'] ?? $allowed;
    }

    protected function pages(): array
    {
        return $this->getConfig('pages', []);
    }
}
