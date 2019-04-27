<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\WP;

class Post_Type
{
    public $args;
    public $labels;
    public $rewrite;
    public $post_type;
    public $base_options;
    public $backalley_options;


    final public function __construct($post_type, $args)
    {
        $this->post_type = $post_type;
        $this->args = $args;

        $this->register_post_types($post_type, $args);

        do_action('backalley/register_post_type', $this->post_type, $this->args);
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
