<?php

namespace Backalley\WP\PostType\Args;

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


    public function custom_args()
    {
        global $wp_filter;


        foreach ($this->custom_args as $name => $arg) {

            $class = $this::arg_to_class($name);
            $hook_tag = "backalley/register_post_type/custom_args/{$name}";
            $method = "handle_{$name}_arg";

            $class = apply_filters($hook_tag, $class, $arg);

            switch (true) {
                case isset($wp_filter[$hook_tag]):
                    do_action($hook_tag, $this->taxonomy_object, $arg);
                    break;

                case class_exists($class) && in_array($this->interface, class_implements($class)):
                    $class::pass($this->taxonomy_object, $arg);
                    break;

                case method_exists($this, $method):
                    $this->$method($arg);
                    break;

                default:
                    throw new \Error("I don't know what you mean. Your Argument is invalid.");
            }
        }
    }

    /**
     * Convert custom argument to class format
     */
    public static function arg_to_class($arg, $class_format = '')
    {
        $bridge = str_replace('_', ' ', $arg);

        $bridge = ucwords($bridge);
        $bridge = str_replace(' ', '', $bridge);

        $class = __NAMESPACE__ . "\\{$bridge}PostTypeArg";

        return $class;
    }
}