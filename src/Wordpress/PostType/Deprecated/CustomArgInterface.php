<?php

namespace Backalley\Wordpress\PostType\Deprecated;

interface CustomArgInterface
{
    /**
     * Set the args to into values need by the functionality
     *
     * @param WP_Post_Type $post_type
     * @param array $args The arguments provided
     */
    public static function pass($post_type, $args);

    /**
     * Optional will be called on wp_loaded action hook
     * return void if not needed
     */
    public static function run();
}
