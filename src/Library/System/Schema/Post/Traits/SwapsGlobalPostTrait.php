<?php

namespace Leonidas\Library\System\Schema\Post\Traits;

use WP_Post;

trait SwapsGlobalPostTrait
{
    protected function swapGlobalPost(WP_Post $replacement): WP_Post
    {
        global $post;

        $cached = $post;

        $post = $replacement;

        return $cached;
    }

    protected function restoreGlobalPost(WP_Post $cached): void
    {
        global $post;

        $post = $cached;
    }
}
