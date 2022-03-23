<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use WP_Post;

class ViewPostConverter implements PostConverterInterface
{
    public function convert(WP_Post $post): ViewPost
    {
        return new ViewPost($post);
    }

    public function revert($post): WP_Post
    {
        /** @var ViewPost $post */
        return get_post($post->getId());
    }
}
