<?php

namespace Backalley\FormFields;

/**
 * 
 */
class Select extends FormField implements FormFieldInterface
{
    /**
     * 
     */
    public static $selected_attribute = 'selected';

    /**
     * 
     */
    public static $item_text = 'content';

    /**
     * 
     */
    public function __toString()
    {
        $html = '';

        $html .= $this->open('select', $this->attributes);

        foreach ($this->options as $value => $option) {
            $option_attr = ['value' => $value];

            if ($value === $this->selected) {
                $option_attr['selected'] = true;
            }

            $html .= $this->open('option', $option_attr);
            $html .= $option;
            $html .= $this->close('option');
        }

        $html .= $this->close('select');

        return $html;
    }

    /**
     * 
     */
    public function parse_args($args)
    {
        $this->options = $args['options'];
        $this->selected = $args['selected'];
        $this->attributes = $args['attributes'];

        return $this;
    }

    /**
     * 
     */
    public static function create($args)
    {
        $multiple = $args['multiple'] ?? false;

        return new Select($args);
    }
}