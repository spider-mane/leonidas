<?php

namespace Leonidas\Hooks;

use Closure;
use WP_Post;

trait TargetsSavePostXPostTypeHook
{
    protected function targetSavePostXPostTypeHook()
    {
        add_action(
            "save_post_{$this->getPostType()}",
            Closure::fromCallable([$this, 'doSavePostXPostTypeAction']),
            $this->getSavePostXPostTypePriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getSavePostXPostTypePriority(): int
    {
        return 10;
    }

    abstract protected function getPostType(): string;

    abstract protected function doSavePostXPostTypeAction(int $postId, WP_Post $post, bool $update): void;
}
