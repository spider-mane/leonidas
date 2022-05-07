<?php

namespace Leonidas\Hooks;

use Closure;
use WP_Post;

trait TargetsAddMetaBoxesXPostTypeHook
{
    protected function targetAddMetaBoxesXPostTypeHook()
    {
        add_action(
            "add_meta_boxes_{$this->getPostType()}",
            Closure::fromCallable([$this, 'doAddMetaBoxesXPostTypeAction']),
            $this->getAddMetaBoxesXPostTypePriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getAddMetaBoxesXPostTypePriority(): int
    {
        return 10;
    }

    abstract protected function getPostType(): string;

    abstract protected function doAddMetaBoxesXPostTypeAction(WP_Post $post): void;
}
