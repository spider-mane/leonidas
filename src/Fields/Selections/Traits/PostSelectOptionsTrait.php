<?php

namespace WebTheory\Leonidas\Fields\Selections\Traits;

use WP_Post;

trait PostSelectOptionsTrait
{
    /**
     *
     */
    public function provideItemContent(WP_Post $post): string
    {
        return $post->post_name;
    }
}
