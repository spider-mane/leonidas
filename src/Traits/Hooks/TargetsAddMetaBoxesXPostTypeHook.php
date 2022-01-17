<?php

namespace Leonidas\Traits\Hooks;

use Closure;
use WP_Post;

trait TargetsAddMetaBoxesXPostTypeHook
{
    protected function targetAddMetaBoxesXPostTypeHook()
    {
        add_action(
            "add_meta_boxes_{$this->getPostType()}",
            $this->getAddMetaBoxesXPostTypeCallback(),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getAddMetaBoxesXPostTypeCallback(): Closure
    {
        return function (WP_Post $post) {
            $this->doAddMetaBoxesXPostTypeAction($post);
        };
    }

    abstract protected function getPostType(): string;

    abstract protected function doAddMetaBoxesXPostTypeAction(WP_Post $post): void;
}
