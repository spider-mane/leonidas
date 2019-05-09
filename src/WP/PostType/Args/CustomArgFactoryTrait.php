<?php

namespace Backalley\WP\PostType\Args;

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

trait CustomArgFactoryTrait
{
    public $custom_args = [];
    public $object_type = '';
    public $interface = __NAMESPACE__ . '\\CustomArgInterface';


    public function custom_arg_factory()
    {
        global $wp_filter;


        foreach ($this->custom_args as $name => $arg) {

            $class = GuctilityBelt::arg_to_class($name, "%sPostTypeArg", __NAMESPACE__);
            $hook_tag = "backalley/post_type/register/args/{$name}";
            $method = "handle_{$name}_arg";

            $class = apply_filters("{$hook_tag}/interface", $class, $arg);

            switch (true) {
                case isset($wp_filter[$hook_tag]):

                    do_action($hook_tag, $this->post_type_object, $arg);
                    break;

                case class_exists($class) && in_array($this->interface, class_implements($class)):

                    $class::pass($this->post_type_object, $arg);
                    add_action($class::$hook ?? 'wp_loaded', [$class, 'run']);
                    break;

                case method_exists($this, $method):

                    $this->$method($arg);
                    break;

                default:
                    throw new \Error("I don't know what you mean. Your Argument is invalid.");
            }
        }
    }
}