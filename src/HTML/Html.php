<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\Html;

class Html
{
    public $html;
    public $charset;
    public $element_array;

    /**
     * 
     */
    public function __construct($element_array = [], $charset = null)
    {
        $this->set_element_array($element_array);
        $this->set_charset($charset);
        $this->set_html($this->element_array);
    }

    /**
     * 
     */
    public function set_charset($charset)
    {
        $this->charset = $charset ?? 'UTF-8';
    }

    /**
     * 
     */
    public function set_element_array($element_array)
    {
        $this->element_array = $element_array;
    }

    /**
     * 
     */
    public function set_html()
    {
        $this->html = $this->construct_element();
    }


    /**
     * starting point of the process of creating the data structure necessary
     * rendering the element. the primary purpose of this method is to provide
     * an api to abstract out the need to explicitly set attrubutes needed for
     * any front end functionality. regardless of whether or not any such api is
     * required or provided, use this method to call parse_attributes()
     */
    // abstract function parse_args($element);// : array;

    /**
     * this method shoud recieve a formatted data structure parse it recursively
     * based on whether or not the current array element has a key labed
     * 'children' with a non empty value. If the condition is true, it should
     * store the closing tag in an array. Any element that does not meet said
     * condition for recursive parsing must automaticcaly 
     * 
     * a custom defined method that anticipates and accordingly establishes the
     * element's structure is required as an intermidiary between the construct_element()
     * and parse_attributes() methods
     */
    public function construct_element($element_array = null, &$el_str = '', $re_call = false)
    {
        // store array provided at initial function call
        static $element_cache;

        // store array of elements that have been processed
        static $marked_up;

        if (!$re_call) {
            // set the element cache and the element to be looped through
            $element_cache = $element_array = $element_array ?? $this->element_array;
            $marked_up = [];
        }


        // loop through $element_array
        foreach ($element_array as $current_element => $definition) {

            if (in_array($current_element, $marked_up)) {
                continue;
            }

            // add strings elements to the element string as they may already exist as markup
            if (is_string($definition)) {
                $el_str .= $definition;
                $marked_up[] = $current_element;
                continue;
            }

            $el_str .= $this->open($definition['tag'], $definition['attributes'] ?? '');

            if (array_key_exists('content', $definition)) {
                $el_str .= $definition['content'];
            }

            // store children in array to be passed as argument in recursive call
            if (!empty($definition['children'])) {

                foreach ($definition['children'] as $child) {
                    $children[$child] = $element_cache[$child];
                }

                $this->construct_element($children, $el_str, true);
            }

            $el_str .= $this->close($definition['tag']);

            $marked_up[] = $current_element;
        }

        // set all static variables to null if in initial call stack
        if (!$re_call) {
            $marked_up = null;
            $element_cache = null;
        }

        return $el_str;
    }

    /**
     * 
     */
    public function construct_element_with_map($order, $element_array, &$el_str = '')
    {
        // code here
    }

    /**
     * 
     */
    public function parse_attributes($attributes_array, &$attr_str = '')
    {
        // static $attr_str = '';

        foreach ($attributes_array as $attr => $val) {

            if (is_string($val) || is_int($val)) {
                $val = is_string($val) ? "\"{$val}\"" : $val;
                $attr_str .= " {$attr}={$val}";
                continue;
            }

            if (is_bool($val) && $val === true) {
                $attr_str .= " {$attr}=\"{$attr}\"";
                continue;
            }

            // val is array of boolean values
            if (is_array($val) && $attr === 'boolean_attributes') {
                foreach ($val as $boolean_attr) {
                    $attr_str .= " {$boolean_attr}";
                }
                continue;
            }

             // $val represents token list
            if (is_array($val) && isset($val[0])) {
                $attr_str .= " {$attr}=\"";

                $i = 0;

                foreach ($val as $thing) {
                    if ($i++ === 0) {
                        $attr_str .= "{$thing}";
                    } else {
                        $attr_str .= " {$thing}";
                    }
                }

                $attr_str .= "\""; // add closing quote
                continue;
            }

            // $val represents a map
            if (is_array($val)) {
                foreach ($val as $set => $setval) {
                    // static::parse_attributes(["{$attr}-{$set}" => $setval]);
                    $this->parse_attributes(["{$attr}-{$set}" => $setval], $attr_str);
                }
                continue;
            }
        }

        return ltrim($attr_str);
    }

    /**
     * 
     */
    public function open(string $tag, $attributes = null, $indent = 0, $new_line = false)
    {
        if (!is_string($attributes) && is_array($attributes)) {
            $attributes = $this->parse_attributes($attributes);
        }

        $attributes = !empty($attributes) ? " {$attributes}" : '';

        $slash = TagSage::is_it('self_closing', $tag) ? ' /' : '';

        if ($new_line === true) {
            $new_line = !TagSage::is_it('whitespace_sensitive', $tag) ? "\n" : '';
        } else {
            $new_line = '';
        }

        return "<{$tag}{$attributes}{$slash}>{$new_line}";
    }

    /**
     * 
     */
    public function close(string $tag)
    {
        // return !in_array($tag, TagSage::$self_closing) ? "</{$tag}>" : '';

        if (TagSage::is_it('self_closing', $tag)) {
            return '';
        }

        return "</{$tag}>";
    }

    public function indent_tag($tag, $level)
    {
        // code here
    }

    public function add_new_line()
    {
        // code here
    }

    /**
     * 
     */
    public static function script($code)
    {
        $tag = '';
        $attributes = [];

        $script = new Html;

        $tag .= $script->open('script', $attributes);
        $tag .= $code;
        $tag .= $script->close('script');
    }
}