<?php

namespace Backalley\WordPress\Taxonomy\Args;

use Backalley\GuctilityBelt;


/**
 * @package Backalley Core
 * 
 * Factory to process custom args
 * 
 * the manner in which custom args are to be handled is detemined in cascading fashion. If a class exists to process
 * the arg the class will be called, if a callback function has been provided via the WP hook api, that function
 * will be called, otherwise if there is a method in this class designated to process that arg, that method will be
 * called to process it
 */

trait CustomTaxonomyArgFactoryTrait
{
    public $custom_args = [];
    public $interface = __NAMESPACE__ . '\\CustomTaxonomyArgInterface';


    public function custom_arg_factory()
    {
        global $wp_filter;


        foreach ($this->custom_args as $name => $arg) {

            $class = GuctilityBelt::arg_to_class($name, "%sTaxonomyArg", __NAMESPACE__);
            $hook_tag = "backalley/taxonomy/register/args/{$name}";
            $method = "handle_{$name}_arg";

            $class = apply_filters("{$hook_tag}/interface", $class, $arg);

            switch (true) {
                case isset($wp_filter[$hook_tag]):

                    do_action($hook_tag, $this->taxonomy_object, $arg);
                    break;

                case class_exists($class) && in_array($this->interface, class_implements($class)):

                    $class::pass($this->taxonomy_object, $arg);
                    add_action('wp_loaded', [$class, 'run']);
                    break;

                case method_exists($this, $method):

                    $this->$method($arg);
                    break;
            }
        }
    }
}