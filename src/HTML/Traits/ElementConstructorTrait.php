<?php

namespace Backalley\Html\Traits;

use Backalley\Html\TagSage;

/**
 *
 */
trait ElementConstructorTrait
{
    /**
     *
     */
    protected static function parseAttributes($attributesArray)
    {
        return static::_parseAttributes($attributesArray);
    }

    /**
     *
     */
    private static function _parseAttributes($attributesArray, &$attrStr = '')
    {
        foreach ($attributesArray as $attr => $val) {

            if (is_string($val) || is_int($val)) {
                $val = is_string($val) ? "\"{$val}\"" : $val;
                $attrStr .= " {$attr}={$val}";
                continue;
            }

            // boolean attribute
            if ($val === true) {
                $attrStr .= " {$attr}=\"{$attr}\"";
                continue;
            }

            if (is_int($attr)) {
                $attrStr .= " {$val}=\"{$val}\"";
                continue;
            }

            // val is array of boolean values
            if (is_array($val) && $attr === 'boolean_attributes') {
                foreach ($val as $booleanAttr) {
                    $attrStr .= " {$booleanAttr}";
                }
                continue;
            }

            // $val represents token list
            if (is_array($val) && isset($val[0])) {
                $attrStr .= " {$attr}=\"";

                $i = 0;

                foreach ($val as $thing) {
                    if ($i++ === 0) {
                        $attrStr .= "{$thing}";
                    } else {
                        $attrStr .= " {$thing}";
                    }
                }

                $attrStr .= "\""; // add closing quote
                continue;
            }

            // $val represents a map
            if (is_array($val)) {
                foreach ($val as $set => $setval) {
                    // static::parse_attributes(["{$attr}-{$set}" => $setval]);
                    static::parseAttributes(["{$attr}-{$set}" => $setval], $attrStr);
                }
                continue;
            }
        }

        return ltrim($attrStr);
    }

    /**
     *
     */
    private static function resolvesToAttribute($attr, $val)
    {
        return is_string($val) || is_int($val);
    }

    /**
     *
     */
    private static function resolvesToBooleanAttribute($attr, $val)
    { }

    /**
     *
     */
    private static function resolvesToTokenListAttribute($attr, $val)
    { }

    /**
     *
     */
    private static function resolvesToMapAttribute($attr, $val)
    { }

    /**
     *
     */
    protected static function open(string $tag, $attributes = null, $options = [])
    {
        if (!is_string($attributes) && is_array($attributes)) {
            $attributes = static::parseAttributes($attributes);
        }

        $attributes = isset($attributes) ? " {$attributes}" : '';

        $newLine = static::newLine($options['new_line'] ?? false);
        $indentation = static::indentation($options['indentation'] ?? 0);
        $slash = static::indentation($options['trailing_slash'] ?? false, $tag);

        return "{$indentation}<{$tag}{$attributes}{$slash}>{$newLine}";
    }

    /**
     *
     */
    protected static function close(string $tag, $options = [])
    {
        if (TagSage::isIt('self_closing', $tag)) {
            return '';
        }

        $indentation = static::indentation($options['indentation'] ?? 0);

        return "{$indentation}</{$tag}>";
    }

    /**
     *
     */
    protected static function trailingSlash(bool $addTrailingSlash, string $tag)
    {
        return $addTrailingSlash && TagSage::isIt('self_closing', $tag) ? ' /' : '';
    }

    /**
     *
     */
    protected static function indentation(int $levels)
    {
        $indentation = '';

        if ($levels > 0) {
            $indentation = str_repeat('&nbsp;', $levels);
        }

        return $indentation;
    }

    /**
     *
     */
    protected static function newLine(bool $newLine)
    {
        return true === $newLine ? "\n" : '';
    }
}
