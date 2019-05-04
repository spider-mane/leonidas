<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\WP;


final class PostType
{
    public $args;
    public $labels;
    public $rewrite;
    public $post_type;
    public $base_options;
    public $backalley_options;

    private static $registered = [];

    const WP_ARGS = ['base', 'labels', 'rewrite'];

    final public function __construct($post_type, $args)
    {
        $this->post_type = $post_type;
        $this->args = $args;

        // $this->set_base();
        // $this->set_labels();
        // $this->set_rewrite();

        $this->register_post_type();
        // $this->post_type_factory();

        do_action('backalley/register_post_type', $this->post_type, $this->args);
    }

    /**
     * 
     */
    final public function set_base()
    {
        $this->base = $args['base'];

        foreach ($this->base as $base_feature => $arg) {
            $this->post_type[$base_feature] = $arg;
        }
    }

    final public function set_rewrite()
    {
        $this->rewrite = $args['rewrite'] ?? [];
        $this->post_type['rewrite'] = $this->rewrite;
    }

    /**
     * 
     */
    final public function set_labels()
    {
        $this->labels = $args['labels'];
        $this->post_type['labels'] = $this->labels;
    }

    /**
     * 
     */
    final public function register_post_type()
    {
        register_post_type($this->post_type, $this->args, 0);
    }

    /**
     * 
     */
    private function post_type_factory()
    {
        foreach ($this->args as $option => $args) {
            if (in_array(WP_ARGS)) {
                continue;
            }

            $class = $this->arg_to_class($option);
            $class = apply_filters("backalley/new/{$class}", $class);

            if (class_exists($class))
                new $class($args);
        }
    }

    /**
     * 
     */
    private function arg_to_class($arg)
    {
        $class = str_replace('_options', '', $arg);
        $class = str_replace('_', ' ', $arg);
        $class = uc_words($arg);
        $class = str_replace(' ', '', $args);
        $class = "Backalley\\{$class}PostTypeArg";

        return $class;
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
}
