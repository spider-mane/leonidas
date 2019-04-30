<?php

namespace Backalley\Html;

class Tag_Sage
{
    /**
     * 
     */
    public static $self_closing = [
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
     * 
     */
    public static $whitespace_sensitive = [
        'textarea',
    ];

    /**
     * 
     */
    public static $form_elements = [
        'input',
        'textarea',
        'select',
        'fieldset',
    ];

    public static $input_types = [
        'text',
        'email',
        'phone',
        'checkbox',
        'radio',
    ];
}