<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\Fields;

use Timber\Timber;

class WpFormField
{
    public $args;

    public function __construct($args)
    {
        // $this->args = $element_array;
        $field = new FormField($args['field']);

        $form_field = [
            'field_id' => $args['field']['attributes']['id'],
            'label' => $args['label'],
            'field' => $field->html,
            'description' => $args['description']
        ];

        Timber::$locations = BackAlley::$timber_locations;
        Timber::render('wp-form-field.twig', $form_field);

        // $this->init_element_array();
        // // $this->instantiate_field();
        // $this->load_content();
        // $this->do_for();

        // $this->construct_element($this->element_array);
    }

    /**
     * 
     */
    public function init_element_array()
    {
        $this->element_array = [
            'row' => [
                'tag' => 'tr',
                'attributes' => [
                    'class' => ['form-field']
                ],
                'children' => ['head', 'data']
            ],
            'head' => [
                'tag' => 'th',
                'attributes' => ['scope' => 'row', 'valign' => 'top'],
                'children' => ['label'],
            ],
            'label' => [
                'tag' => 'label',
                'attributes' => ['for' => ''],
                'content' => ''
            ],
            'data' => [
                'tag' => 'td',
                'attributes' => [],
                'children' => ['field', 'description']
            ],
            'field' => [],
            'description' => [
                'tag' => 'span',
                'content' => '',
                'attributes' => [
                    'class' => ['description']
                ]
            ]
        ];
    }

    /**
     * 
     */
    public function instantiate_field()
    {
        $field = new FormField($this->args['field']);

        $this->element_array['field'] = $field->html;
    }

    /**
     * 
     */
    public function load_content()
    {
        foreach ($this->args as $arg => $value) {
            if (isset($this->element_array[$arg]['content'])) {
                $this->element_array[$arg]['content'] = $value;
            }
        }

        // $this->element_array['label']['content'] = $this->args['label'];        
    }

    public function do_for()
    {
        $this->element_array['label']['attributes']['for'] = $this->args['field']['attributes']['id'];
    }
}