<?php

/**
 * @package Backalley-Core
 * 
 * Simple factory to generate field
 */

namespace Backalley\Fields;

use Backalley\Html\Tag_Sage;


final class Form_Element extends \Backalley\Html\Html
{
    public $element;

    /**
     *
     */
    public function __construct($element = null, $charset = null)
    {
        $this->parse_args($element);
        $this->set_charset($charset);
    }

    /**
     * 
     */
    public function parse_args($element)
    {
        $this->form_element = $element['form_element'];

        switch (Tag_Sage::is_it('standard_form_element', $this->form_element)) {

            case false:
                $this->custom_field($element);
                break;

            case true:
                $field = $this->form_element;
                $this->$field($element);
                break;
        }
    }

    /**
     *
     */
    public function input($element)
    {
        $type = $element['type'] ?? $element['attributes']['type'] ?? 'text';

        if (Tag_Sage::is_it('standard_input_type', $type)) {

            $tag = $element['form_element'];
            $attributes = &$element['attributes'];
            $attributes['type'] = $type;

            $this->html = $this->open($tag, $attributes);

        } else {
            $input = ucwords(str_replace('_', ' ', $type));
            $input = __NAMESPACE__ . '\\' . str_replace(' ', '_', $input);

            $input = new $input($element);
            $this->html = $input->html;
        }
    }

    /**
     *
     */
    public function select($element)
    {
        $html = '';

        $tag = $element['form_element'];
        $options = $element['options'];
        $selected = $element['selected'] ?? '';
        $attributes = $element['attributes'] ?? [];

        $html .= $this->open($tag, $attributes);

        foreach ($options as $value => $option) {
            $option_attr = ['value' => $value];

            if ($value === $selected) {
                $option_attr['selected'] = true;
            }

            $html .= $this->open('option', $option_attr);
            $html .= $option;
            $html .= $this->close('option');
        }

        $html .= $this->close($tag);

        $this->html = $html;
    }

    /**
     *
     */
    public function textarea($element)
    {
        $html = '';

        $tag = $element['form_element'];
        $content = $element['content'];
        $attributes = $element['attributes'];

        $html .= $this->open($tag, $attributes);
        $html .= $content;
        $html .= $this->close($tag);

        $this->html = $html;
    }

    /**
     *
     */
    public function fieldset($element)
    {
        $html .= '';

        $tag = $element['form_element'];
        $attributes = $element['attributes'];
        $fields = $element['fields'];

        $html .= $this->open($tag, $attributes);

        foreach ($fields as $field) {
            $field = new Form_Element($field);

            $html .= $field->html;
        }

        $html .= $this->close($tag);

        $this->html = $html;
    }

    /**
     * 
     */
    public static function new_fields($fields)
    {
        foreach ($fields as $field) {
            return new Form_Element($field);
        }
    }

    /**
     * Instantiate custom field if $form_element is nor a standard HTML5 form field
     */
    private function custom_field($element)
    {
        // convert argument to FQN
        $field = ucwords(str_replace('_', ' ', $this->form_element));
        $field = __NAMESPACE__ . '\\' . str_replace(' ', '_', $field);

        $field = new $field($element);
        $this->html = $field->html;
    }
}
