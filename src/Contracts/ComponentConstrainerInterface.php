<?php

namespace WebTheory\Leonidas\Contracts;

use WP_Post;

interface ComponentConstrainerInterface
{
    /**
     *
     */
    public function loadComponentForPost(WP_Post $post);
}
