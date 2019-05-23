<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\WordPress;


final class PostType
{
    public $post_type;
    public $base_args;
    public $post_type_object;

    private static $registered = [];

    use PostType\Args\CustomArgFactoryTrait;

    final public function __construct($post_type, $args)
    {
        $this->set_post_type($post_type);
        $this->set_base_args($args);
        $this->set_custom_args($args);
        $this->register_post_type();

        if (!empty($this->custom_args)) {
            $this->custom_arg_factory();
        }
    }

    /**
     * 
     */
    public function set_post_type(string $post_type)
    {
        $this->post_type = $post_type;
    }

    /**
     * 
     */
    public function set_base_args($args)
    {
        unset($args['backalley_custom_args']);
        $this->base_args = $args;
    }

    /**
     * 
     */
    public function set_custom_args($args)
    {
        $this->custom_args = $args['backalley_custom_args'] ?? null;
    }

    /**
     * 
     */
    final public function set_labels()
    {

    }

    /**
     * 
     */
    final public function register_post_type()
    {
        register_post_type($this->post_type, $this->base_args, 0);
        $this->post_type_object = get_post_type_object($this->post_type);
    }


    /**
     * 
     */
    public static function get_registered()
    {
        return Self::$registered;
    }

    /**
     * Callback to be provided to 
     */
    public static function unregistered()
    {

    }

    /**
     * 
     */
    public static function bulk_registration($post_types = [])
    {
        foreach ($post_types as $post_type => $args) {
            new PostType($post_type, $args);
        }
    }
}
