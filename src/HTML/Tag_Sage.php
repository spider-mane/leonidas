<?php

namespace Backalley\Html;

class Tag_Sage
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
    public static function is_it($query, $value)
    {
        return in_array($value, Self::$$query) ? true : false;
    }

    /**
     * To be called on load if browser info has been requested. 
     * Used to modify property arrays based on browser info.
     * 
     * @param string $browser current browser
     */
    public static function ponder($browser)
    {
        // code here
    }
}