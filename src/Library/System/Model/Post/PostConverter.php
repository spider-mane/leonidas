<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use WP_Post;

class PostConverter implements PostConverterInterface
{
    public function convert(WP_Post $post): Post
    {
        return new Post($post);
    }

    public function revert($post): WP_Post
    {
        /** @var Post $post */
        return get_post($post->getId());
    }
}
