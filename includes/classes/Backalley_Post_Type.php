<?php

/**
 * description here
 */

// namespace Backalley\Api;

class Backalley_Post_Type
{
    final public function __construct($post_type, $args)
    {
        $this->register_post_types($post_type, $args);

        // do_action('backalley/register_post_type', $something);
    }

    final public function register_post_types($post_type, $args)
    {
        register_post_type($post_type, $args, 0);
    }

    final public static function update_post_meta($post_id, $meta_key, $meta_value, $prev_value)
    {
        // code here
    }
}
