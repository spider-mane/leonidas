<?php

namespace Leonidas\Contracts\System\Schema\Post;

use WP_Post;

interface PostConverterInterface
{
    public function convert(WP_Post $post);

    public function revert($post): WP_Post;
}
