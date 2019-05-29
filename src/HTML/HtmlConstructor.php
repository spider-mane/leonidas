<?php

namespace Backalley\Html;


/**
 * @package Backalley-Core
 */
abstract class HtmlConstructor
{
    /**
     * 
     */
    public $charset;

    /**
     * 
     */
    public function __construct(array $args = [], string $charset = null)
    {
        $this->set_charset($charset);
    }

    /**
     * 
     */
    abstract public function __toString();

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
    protected static function parse_attributes($attributes_array, &$attr_str = '')
    {
        // static $attr_str = '';

        foreach ($attributes_array as $attr => $val) {

            if (is_string($val) || is_int($val)) {
                $val = is_string($val) ? "\"{$val}\"" : $val;
                $attr_str .= " {$attr}={$val}";
                continue;
            }
            
            // boolean attribute
            if ($val === true) { 
                $attr_str .= " {$attr}=\"{$attr}\"";
                continue;
            }

            if (is_int($attr)) { 
                $attr_str .= " {$val}=\"{$val}\"";
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
                    Self::parse_attributes(["{$attr}-{$set}" => $setval], $attr_str);
                }
                continue;
            }
        }

        return ltrim($attr_str);
    }

    /**
     * 
     */
    protected static function open(string $tag, $attributes = null, $indent = 0, $new_line = false)
    {
        if (!is_string($attributes) && is_array($attributes)) {
            $attributes = Self::parse_attributes($attributes);
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
    protected static function close(string $tag)
    {
        // return !in_array($tag, TagSage::$self_closing) ? "</{$tag}>" : '';

        if (TagSage::is_it('self_closing', $tag)) {
            return '';
        }

        return "</{$tag}>";
    }

    /**
     * 
     */
    protected static function indent($tag, $level)
    {
        // code here
    }

    /**
     * 
     */
    protected static function new_line()
    {
        // code here
    }
}