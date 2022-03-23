<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use WP_Post;

class QueryPostConverter implements PostConverterInterface
{
    public function convert(WP_Post $post): QueryPost
    {
        return new QueryPost();
    }

    public function revert($post): WP_Post
    {
        /** @var QueryPost $post */
        return get_post($post->getId());
    }
}
