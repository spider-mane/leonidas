<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\Fields;

use Backalley\Html\HtmlConstructor;


class Checklist extends HtmlConstructor implements FormFieldInterface
{
    public $args;

    use \Backalley\Html\HtmlMapConstructorTrait;

    /**
     * 
     */
    public function __construct($args, $charset = null)
    {
        $this->set_args($args);

        $this->init_html_map();
        $this->populate_static_element_attributes();
        $this->define_toggle_control();
        $this->define_clear_control();
        $this->populate_instances();

        parent::__construct($this->html_map, $charset);
    }

    /**
     * 
     */
    public function set_args($args)
    {
        $this->args = $args;
    }

    /**
     * 
     */
    public function init_html_map()
    {
        $this->html_map = [
            'container' => [
                'tag' => 'div',
                'children' => 'ul'
            ],
            'ul' => [
                'tag' => 'ul',
                'children' => ['clear_control', 'items']
            ],
            'clear_control' => [
                'tag' => 'li',
                'attributes' => [
                    'type' => 'hidden',
                    'value' => ''
                ],
            ],
            'items' => [
                'li' => [
                    'tag' => 'li',
                    'children' => ['toggle', 'checkbox', 'label'],
                    'instances' => []
                ],
                'toggle' => [
                    'tag' => 'input',
                    'instances' => []
                ],
                'checkbox' => [
                    'tag' => 'input',
                    'instances' => []
                ],
                'label' => [
                    'tag' => 'label',
                    'instances' => []
                ]
            ],
        ];
    }

    /**
     * 
     */
    public function populate_static_element_attributes()
    {
        foreach ($this->html_map as $element => &$values) {

            if (isset($this->args[$element]['attributes'])) {
                // $values['attributes'] = $this->args[$element]['attributes'];
                $values['attributes'] = $this->parse_attributes($this->args[$element]['attributes']);
            }
        }
    }

    /**
     * 
     */
    public function define_clear_control()
    {
        if (!isset($this->args['clear_control'])) {
            unset($this->html_map['clear_control']);

            $clear_control = array_search('clear_control', $this->html_map['ul']['children']);
            unset($this->html_map['ul']['children'][$clear_control]);

        } else {
            $this->html_map['clear_control']['attributes']['name'] = $this->args['clear_control'];
        }
    }

    /**
     * 
     */
    public function define_toggle_control()
    {
        if (!isset($this->args['toggle']) || isset($this->args['toggle']) && $this->args['toggle'] === false) {
            unset($this->html_map['items']['toggle']);

            $toggle = array_search('toggle', $this->html_map['items']['li']['children']);
            unset($this->html_map['items']['li']['children'][$toggle]);

        } else {
            foreach ($this->args['items'] as $item) {

                $toggle_instances = &$this->html_map['items']['toggle']['instances'];

                $toggle_instances[] = [
                    'attributes' => [
                        'type' => 'hidden',
                        'value' => '0',
                        'name' => $item['attributes']['name']
                    ]
                ];
            }
        }
    }

    /**
     * 
     */
    public function populate_instances()
    {
        foreach ($this->args['items'] as $item) {

            $checkbox_instances = &$this->html_map['items']['checkbox']['instances'];
            $li_instances = &$this->html_map['items']['li']['instances'];
            $label_instances = &$this->html_map['items']['label']['instances'];

            if (!isset($item['attributes']['type'])) {

            }
            $checkbox_attributes = $item['attributes'] ?? [];
            $li_attributes = $item['li']['attributes'] ?? [];
            $label_attributes = $item['label']['attributes'] ?? [];

            if (!isset($item['attributes']['type'])) {
                $checkbox_attributes['type'] = 'checkbox';
            }


            $checkbox_instances[] = [
                'attributes' => $this->parse_attributes($checkbox_attributes),
            ];

            $li_instances[] = [
                'attributes' => $this->parse_attributes($li_attributes),
            ];

            $label_instances[] = [
                'content' => $item['label']['content'],
                'attributes' => $this->parse_attributes($label_attributes),
            ];
        }
    }
} 
