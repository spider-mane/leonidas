<?php

namespace WebTheory\Leonidas\Core\Contracts;

use WP_Post_Type;

interface PostTypeOptionHandlerInterface
{
    /**
     * Set arguments into values needed to implement the functionality
     *
     * @param WP_Post_Type $postType
     * @param array $args The arguments provided
     */
    public static function handle(WP_Post_Type $postType, $args);
}
