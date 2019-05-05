<?php

/**
 * @package Backalley-Core
 * 
 * Simple factory to generate field
 */

namespace Backalley\Fields;

use Backalley\Html\TagSage;


final class FormField extends \Backalley\Html\HtmlConstructor
{
    public $args;

    /**
     *
     */
    public function __construct($args = null, $charset = null)
    {
        $this->parse_args($args);
        $this->set_charset($charset);
    }

    /**
     * 
     */
    public function parse_args($args)
    {
        $this->form_element = $args['form_element'];
        $method = $this->form_element;
        $class = $this->arg_to_class();

        switch (true) {
            case class_exists($class):
                $this->custom_field($class, $args);
                break;

            case TagSage::is_it('standard_form_element', $this->form_element) && method_exists($this, $method):
                $field = $this->form_element;
                $this->$field($args);
                break;
        }
    }

    /**
     *
     */
    public function input($args)
    {
        $type = $args['type'] ?? $args['attributes']['type'] ?? 'text';

        if (TagSage::is_it('standard_input_type', $type)) {

            $tag = $args['form_element'];
            $attributes = &$args['attributes'];
            $attributes['type'] = $type;

            $this->html = $this->open($tag, $attributes);

        } else {
            $input = ucwords(str_replace('_', ' ', $type));
            $input = __NAMESPACE__ . '\\' . str_replace(' ', '_', $input);

            $input = new $input($args);
            $this->html = $input->html;
        }
    }

    /**
     *
     */
    public function select($args)
    {
        $html = '';

        $tag = $args['form_element'];
        $options = $args['options'];
        $selected = $args['selected'] ?? '';
        $attributes = $args['attributes'] ?? [];

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
    public function textarea($args)
    {
        $html = '';

        $tag = $args['form_element'];
        $content = $args['content'];
        $attributes = $args['attributes'];

        $html .= $this->open($tag, $attributes);
        $html .= $content;
        $html .= $this->close($tag);

        $this->html = $html;
    }

    /**
     *
     */
    public function fieldset($args)
    {
        $html .= '';

        $tag = $args['form_element'];
        $attributes = $args['attributes'];
        $fields = $args['fields'];

        $html .= $this->open($tag, $attributes);

        foreach ($fields as $field) {
            $field = new FormField($field);

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
            return new FormField($field);
        }
    }

    /**
     * Convert form_field to FQN
     */
    public function arg_to_class()
    {
        $class = ucwords(str_replace('_', ' ', $this->form_element));
        $class = __NAMESPACE__ . '\\' . str_replace(' ', '_', $class);

        return $class;
    }

    /**
     * Instantiate custom field if $form_element is nor a standard HTML5 form field
     */
    private function custom_field($class, $args)
    {
        $field = new $class($args);
        $this->html = $field->html;
    }
}
