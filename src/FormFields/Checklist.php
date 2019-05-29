<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\FormFields;

use Backalley\Html\HtmlConstructor;
use Backalley\FormFields\MultiValueTrait;


class Checklist extends InputList implements FormFieldInterface
{
    /**
     * {@inheritDoc}
     */
    public $input_type = 'checkbox';

    /**
     * 
     */
    public $toggle;

    /**
     * 
     */
    public $clear;

    /**
     * 
     */
    public $clear_control;

    /**
     * 
     */
    public $toggle_control;

    /**
     * 
     */
    public $selected_attribute = 'checked';

    /**
     * 
     */
    public static $item_text = 'label';

    // use MultiValueTrait;

    /**
     * 
     */
    public function __toString()
    {
        $html = '';

        $html .= $this->open('div', $this->attributes ?? null);
        $html .= isset($this->clear_control) ? $this->open('input', $this->clear_control['attributes']) : '';
        $html .= $this->open('ul', $this->ul['attributes'] ?? null);

        foreach ($this->items as $item) {
            $li = $item['li'] ?? null;
            $label = $item['label'] ?? null;
            $toggle = $item['toggle'] ?? null;

            // opening tag for list item
            $html .= $this->open('li', $li['attributes'] ?? null);

            // toggle control and/or and item 
            $html .= isset($toggle) ? $this->open('input', $toggle['attributes'] ?? null) : '';
            $html .= $this->open('input', $item['attributes'] ?? null);

            // create label
            $html .= $this->open('label', $label['attributes'] ?? null);
            $html .= $label['content'] ?? '';
            $html .= $this->close('label');

            // close li
            $html .= $this->close('li');
        }

        $html .= $this->close('ul');
        $html .= $this->close('div');

        return $html;
    }

    /**
     * 
     */
    protected function parse_args($args)
    {
        parent::parse_args($args);

        if (isset($args['clear_control'])) {
            $this->set_clear_control(...$args['clear_control']);
        }

        if (isset($args['toggle'])) {
            $this->set_toggle_control($args['toggle']);
            $this->define_items_toggle();
        }
    }

    /**
     * 
     */
    public function set_clear_control(string $name, string $value)
    {
        $this->clear_control = [
            'attributes' => [
                'type' => 'hidden',
                'name' => $name,
                'value' => $value,
            ]
        ];

        return $this;
    }

    /**
     * 
     */
    public function set_toggle_control($toggle_control)
    {
        $this->toggle_control = $toggle_control;
    }

    /**
     * 
     */
    protected function define_items_toggle()
    {
        if (isset($this->toggle_control)) {
            foreach ($this->items as &$item) {
                $item['toggle']['attributes'] = [
                    'type' => 'hidden',
                    'name' => $item['attributes']['name'],
                    'value' => $this->toggle_control,
                ];
            }
        }
    }
} 
