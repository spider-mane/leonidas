<?php

namespace Leonidas\Library\Admin\Fields\Selections\Traits;

use WP_Post;

trait PostSelectOptionsTrait
{
    /**
     * @param WP_Post $post
     */
    public function defineSelectionText($post): string
    {
        return $post->post_name;
    }
}
