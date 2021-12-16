<?php

namespace Leonidas\Traits\Hooks;

use Closure;
use WP_Post;

trait TargetsAddMetaBoxesPostTypeHook
{
    protected function targetAddMetaBoxesPostTypeHook()
    {
        add_action(
            "add_meta_boxes_{$this->getPostType()}",
            $this->getAddMetaBoxesPostTypeCallback(),
            null,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getAddMetaBoxesPostTypeCallback(): Closure
    {
        return function (WP_Post $post) {
            $this->doAddMetaBoxesPostTypeAction($post);
        };
    }

    abstract protected function getPostType(): string;

    abstract protected function doAddMetaBoxesPostTypeAction(WP_Post $post): void;
}
