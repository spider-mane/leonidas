<?php

namespace Leonidas\Hooks;

use WP_Post;

trait TargetsSavePostHook
{
    protected function targetSavePostHook()
    {
        add_action(
            'save_post',
            $this->doSavePostAction(...),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    abstract protected function doSavePostAction(int $postId, WP_Post $post, bool $update): void;
}
