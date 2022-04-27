<?php

namespace Leonidas\Contracts\System\Schema\Post;

use WP_Post;

interface PostConverterInterface
{
    public function convert(WP_Post $post): object;

    public function revert(object $entity): WP_Post;
}
