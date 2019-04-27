<?php

/**
 * 
 */

class HTML_Element2 extends HTML_Element
{
    /**
     * 
     */
    public function parse_attribute_list($attributes_array)
    {
        static $attr_str = '';

        foreach ($attributes_array as $attr => $val) {

            if (is_string($val) || is_int($val)) {
                $val = is_string($val) ? "\"{$val}\"" : $val;
                $attr_str .= " {$attr}={$val}";
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

                foreach ($val as $token) {
                    if (0 !== $i++) {
                        $attr_str .= " {$token}";
                    } else {
                        $attr_str .= "{$token}";
                    }
                }

                $attr_str .= "\""; // add closing quote
                continue;
            }

            // $val represents a map
            if (is_array($val)) {
                foreach ($val as $set => $setval) {
                    // static::parse_attributes(["{$attr}-{$set}" => $setval]);
                    $this->parse_attributes(["{$attr}-{$set}" => $setval]);
                }
                continue;
            }
        }

        return ltrim($attr_str);
    }
}