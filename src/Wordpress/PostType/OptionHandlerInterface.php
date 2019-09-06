<?php

namespace Backalley\WordPress\PostType;

interface OptionHandlerInterface
{
    /**
     * Set the args to into values need by the functionality
     *
     * @param \WP_Post_Type $postType
     * @param array $args The arguments provided
     */
    public static function handle(\WP_Post_Type $postType, $args);
}
