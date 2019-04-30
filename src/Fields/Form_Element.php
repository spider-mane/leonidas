<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\Fields;

final class Form_Element extends \Backalley\Html\Html
{
    public $element;

    /**
     *
     */
    public function __construct($element = null, $element_array = null)
    {
        $this->parse_args($element);
    }

    /**
     * 
     */
    public function parse_args($element, $element_data = null)// : array
    {
        $this->form_element = $element['form_element'];

        $this->{$this->form_element}($element);
    }

    /**
     *
     */
    public function input($element)
    {
        $tag = $element['form_element'];
        $attributes = $element['attributes'];

        $this->html = $this->open($tag, $attributes);
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
    public function checklist($element)
    {
        $checklist = new Checklist($element);
        $this->html = $checklist->html;
    }

    /**
     * 
     */
    public function radiolist($element)
    {
        // $radiolist = new Radiolist_Element($element);
        // $this->html = $radiolist->html;
    }

    /**
     * 
     */
    public function wp_terms_checklist($element)
    {
        // $terms_checklist = new Terms_Checklist_Element($element);
        // $this->html = $terms_checklist->html;
    }

    /**
     * 
     */
    public function wp_terms_radiolist($element)
    {
        // $terms_radiolist = new Terms_Radiolist_Element($element);
        // $this->html = $terms_radiolist->html;
    }
}