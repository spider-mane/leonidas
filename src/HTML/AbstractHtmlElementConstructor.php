<?php

namespace Backalley\Html;


/**
 * @package Backalley-Core
 */
abstract class AbstractHtmlElementConstructor
{
    /**
     *
     */
    protected $charset = 'UTF-8';

    /**
     * @var array
     */
    public $attributes = [];

    /**
     *
     */
    public function __construct()
    {
        // do something maybe
    }

    /**
     * Get the value of charset
     *
     * @return mixed
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     *
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * Get the value of attributes
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Set the value of attributes
     *
     * @param array  $attributes
     *
     * @return self
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->addAttribute($key, $value);
        }

        return $this;
    }

    /**
     * Add individual attribute
     *
     * @param array $attribute
     *
     * @return self
     */
    public function addAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value;

        return $this;
    }

    /**
     *
     */
    protected static function parseAttributes($attributes_array, &$attr_str = '')
    {
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
                    static::parseAttributes(["{$attr}-{$set}" => $setval], $attr_str);
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
            $attributes = static::parseAttributes($attributes);
        }

        $attributes = !empty($attributes) ? " {$attributes}" : '';

        $slash = TagSage::isIt('self_closing', $tag) ? ' /' : '';

        if ($new_line === true) {
            $new_line = !TagSage::isIt('whitespace_sensitive', $tag) ? "\n" : '';
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

        if (TagSage::isIt('self_closing', $tag)) {
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
    protected static function newLine()
    {
        // code here
    }

    /**
     *
     */
    abstract public function __toString();
}
