<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\FormFields;

use Backalley\Html\HtmlConstructor;
use Backalley\FormFields\MultiValueTrait;


class Checklist extends HtmlConstructor implements FormFieldInterface
{
    /**
     * 
     */
    public $toggle;

    /**
     * 
     */
    public $clear;

    // use MultiValueTrait;

    /**
     * 
     */
    public function __toString()
    {
        $this->parse_arguments();
        $html = '';

        $container = $this->html_map['container'] ?? [];
        $ul = $this->html_map['ul'] ?? [];
        $items = $this->html_map['items'] ?? [];
        $clear_control = $this->html_map['clear_control'] ?? null;

        $html .= $this->open('div', $container['attributes'] ?? null);
        $html .= $this->open('ul', $ul['attributes'] ?? null);
        $html .= isset($clear_control) ? $this->open('input', $clear_control['attributes'] ?? null) : '';

        foreach ($items as $item) {
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
    public function parse_arguments()
    {
        $this->define_items_type();
        $this->define_toggle();
        $this->define_clear_control();
    }

    /**
     * 
     */
    public function set_clear_control($clear_control)
    {
        $this->clear_control = $clear_control;
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
    public function define_items_type()
    {
        foreach ($this->html_map['items'] as &$item) {
            $item['attributes']['type'] = 'checkbox';
        }
    }

    /**
     * 
     */
    public function define_toggle()
    {
        $toggle = $this->html_map['toggle'] ?? null;

        if (isset($toggle)) {
            foreach ($this->html_map['items'] as &$item) {
                $item['toggle']['attributes'] = [
                    'type' => 'hidden',
                    'name' => $item['attributes']['name'],
                    'value' => $toggle,
                ];
            }
        }
    }

    /**
     * 
     */
    public function define_clear_control()
    {
        $clearControl = &$this->html_map['clear_control'] ?? null;

        if (isset($clearControl)) {
            $clearControl = [
                'attributes' => [
                    'type' => 'hidden',
                    'name' => $clearControl[0],
                    'value' => $clearControl[1],
                ]
            ];
        }
    }
} 
