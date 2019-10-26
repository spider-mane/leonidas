<?php

/**
 * @package Leonidas Core
 *
 * Helper class to determine whether or not a tag meets a certain criteria
 */

namespace WebTheory\Html;

class TagSage
{
    /**
     * Array of self closing tags
     */
    protected static $self_closing = [
        'area',
        'base',
        'br',
        'col',
        'embed',
        'hr',
        'img',
        'input',
        'link',
        'meta',
        'param',
        'source',
        'track',
        'wbr',
    ];

    /**
     * Array of whitespace sensitice tags
     */
    protected static $whitespace_sensitive = [
        'textarea',
    ];

    /**
     * Array of standard HTML5 form elements
     */
    protected static $standard_form_element = [
        'button',
        'datalist',
        'fieldset',
        'input',
        'keygen',
        'label',
        'legend',
        'meter',
        'optgroup',
        'option',
        'progress',
        'select',
        'textarea',
    ];

    /**
     * Array of standard HTML5 input types
     */
    protected static $standard_input_type = [
        'button',
        'checkbox',
        'color',
        'date',
        'datetime-local',
        'email',
        'file',
        'hidden',
        'image',
        'month',
        'number',
        'password',
        'radio',
        'range',
        'reset',
        'search',
        'submit',
        'tel',
        'text',
        'time',
        'url',
        'week',
    ];

    /**
     *
     */
    public static function isIt($query, $value)
    {
        $answer = in_array($value, Self::$$query) ? true : false;

        return $answer;
    }

    /**
     *
     */
    public static function whatAre($these)
    {
        switch ($these) {
            case 'self_closing_tags':
                return Self::$self_closing;

            case 'whitespace_sensitive_tags':
                return Self::$whitespace_sensitive;

            case 'standard_form_elements':
                return Self::$standard_form_element;

            case 'standard_input_types':
                return Self::$standard_input_type;
        }
    }

    /**
     * To be called on load if browser info has been requested.
     * Used to modify property arrays based on browser info.
     *
     * @todo actually make it
     *
     * @param string $browser current browser
     */
    public static function ponder($browser)
    {
        // code here
    }
}
