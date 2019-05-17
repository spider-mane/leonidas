<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\Html;

class HtmlConstructor
{
    public $html;
    public $charset;
    public $html_map;
    public $html_2d_map;
    public $current_element;

    /**
     * 
     */
    public function __construct(array $html_map = [], string $charset = null)
    {
        $this->set_html_map($html_map);
        $this->set_charset($charset);
        // $this->parse_args();
        $this->set_html();
    }

    /**
     * 
     */
    public function set_charset($charset)
    {
        $this->charset = $charset ?? 'UTF-8';

        return $this;
    }

    /**
     * 
     */
    public function set_html_map($html_map)
    {
        $this->html_map = $html_map;

        return $this;
    }

    // /**
    //  * 
    //  */
    // public function parse_args()
    // {
    //     return;
    // }

    /**
     * 
     */
    public function set_html()
    {
        $this->html = $this->construct_html();

        return $this;
    }

    /**
     * genterates an html string from 
     * 
     * @param array $html_map
     * @param bool $recall
     * 
     * @return string
     */
    public function construct_html($map = null, $recall = false)
    {
        $html = '';
        static $marked_up;

        if (!$recall) {
            $marked_up = [];
        }

        foreach ($map ?? $this->html_map as $current_element => $definition) {

            if (in_array($current_element, $marked_up)) {
                continue;
            }

            // add values already existing as strings to $html as they may already exist as markup
            if (is_string($definition)) {
                $html .= $definition;
                $marked_up[] = $current_element;
                continue;
            }

            $html .= $this->open($definition['tag'], $definition['attributes'] ?? '');
            $html .= $definition['content'] ?? '';

            // store children in array to be passed as $html_map argument in recursive call
            if (!empty($children = $definition['children'] ?? null)) {
                foreach ($children as $child) {
                    $child_map[$child] = $this->html_map[$child];
                }

                $html .= $this->construct_html($child_map, true);
            }

            $html .= $this->close($definition['tag']);
            $marked_up[] = $current_element;
        }

        // reset static variables if in initial call stack
        if (!$recall) {
            $marked_up = null;
        }

        return $html;
    }

    /**
     * 
     */
    public function construct_html_2d($order, $html_map, &$el_str = '')
    {
        //
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

        $script = new HtmlConstructor;

        $tag .= $script->open('script', $attributes);
        $tag .= $code;
        $tag .= $script->close('script');
    }
}