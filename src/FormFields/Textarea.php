<?php

namespace Backalley\FormFields;

class Textarea extends FormField implements FormFieldInterface
{
    /**
     * 
     */
    public $content = '';

    /**
     * 
     */
    public $attributes = [];

    public function __toString()
    {
        $html = '';

        $html .= $this->open('textarea', $this->attributes);
        $html .= $this->content;
        $html .= $this->close('textarea');

        return $html;
    }

    /**
     * 
     */
    public function parse_args($args)
    {
        $this->content = $args['content'] ?? $this->content;
        $this->attributes = $args['attributes'] ?? $this->attributes;
    }

    /**
     * 
     */
    public static function create($args)
    {
        return new Textarea($args);
    }
}