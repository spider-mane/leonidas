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
    public function construct_element($element_array = null, &$el_str = '', &$closing_tags = [], $parsed = false)
    {
        // store array provided at initial function call
        static $element_cache;

        // store array of elements that have been processes
        static $marked_up;

        //
        static $closed_out;

        /**
         * have element array parsed to ensure proper format
         */
        if (!$parsed) {
            $element_cache = $element_array ?? $this->element_array;
            $marked_up = [];
            $closed_out = [];
        }

        // loop through $element_array
        foreach (!$parsed ? $element_cache : $element_array as $current_element => $definition) {

            if (in_array($current_element, $marked_up)) {
                continue;
            }

            if (is_string($definition)) {
                $el_str .= $definition;
                $marked_up[] = $current_element;
                continue;
            }

            $open = $this->open($definition['tag'], $definition['attributes'] ?? '');
            $close = $this->close($definition['tag']);

            $el_str .= $open;

            if (array_key_exists('content', $definition)) {
                $el_str .= $definition['content'];
            }

            $closing_tags[$current_element] = $close;


            // close out elements without children
            if (empty($definition['children']) && !in_array($current_element, $closed_out)) {
                $el_str .= $close;
                $closed_out[] = $current_element;
            }

            $marked_up[] = $current_element;
            // store children in array to be individually passed as argument in recursion
            if (!empty($definition['children'])) {

                foreach ($definition['children'] as $child) {
                    $next_element[$child] = $element_cache[$child];
                }

                break;
            }
        }
        

        // recursively parse nested children
        if (isset($next_element)) {

            foreach ($next_element as $key => $next_up) {

                if (!in_array($key, $marked_up)) {
                    $thats_meta[$key] = $next_up;
                    $this->construct_element($thats_meta, $el_str, $closing_tags, true);
                }
            }
        }

        // insert closing tag for parent level elements
        // even outside of loop context, $current_element will be any element with children
        if (!in_array($current_element, $closed_out) && !is_string($definition)) {
            $el_str .= $close;
            $closed_out[] = $current_element;
        }


        // recursively call function until all elements have been parsed
        if (!$parsed && count($element_cache) !== count($marked_up)) {
            $this->construct_element($element_array, $el_str, $closing_tags, true);
        }

        // if (count($element_array) > 0) {
        //     $this->construct_element($element_array, $el_str, $closing_tags, true);
        // }

        // set all static variables to null if in initial call stack
        if (!$parsed) {
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

        $slash = Tag_Sage::is_it('self_closing', $tag) ? ' /' : '';

        if ($new_line === true) {
            $new_line = !Tag_Sage::is_it('whitespace_sensitive', $tag) ? "\n" : '';
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
        // return !in_array($tag, Tag_Sage::$self_closing) ? "</{$tag}>" : '';

        if (Tag_Sage::is_it('self_closing', $tag)) {
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