<?php

namespace Leonidas\Hooks;

use WP_Post;

trait TargetsDeletePostHook
{
    protected function targetDeletePostHook()
    {
        add_action(
            'delete_post',
            $this->doDeletePostAction(...),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    abstract protected function doDeletePostAction(int $postId, WP_Post $post): void;
}
