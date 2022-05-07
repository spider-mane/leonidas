<?php

namespace Leonidas\Hooks;

use Closure;
use WP_Post;

trait TargetsAddMetaBoxesHook
{
    protected function targetAddMetaBoxesHook()
    {
        add_action(
            'add_meta_boxes',
            $this->getAddMetaBoxesCallback(),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getAddMetaBoxesCallback(): Closure
    {
        return function (string $postType, WP_Post $post) {
            $this->doAddMetaBoxesAction($postType, $post);
        };
    }

    abstract protected function doAddMetaBoxesAction(string $postType, WP_Post $post): void;
}
