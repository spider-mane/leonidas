<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use WP_Post;

trait PolymorphicPostModelTrait
{
    protected WP_Post $post;

    public function getPostFormat(): string
    {
        return $this->post->post_format;
    }
}
