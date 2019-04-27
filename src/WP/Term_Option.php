<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\WP;

class Term_Option
{
    public $args;
    public $form_field_callback;
    public $save_term_callback;

    public function __construct($args)
    {
        $this->taxonomy = $args['taxonomy'];
        $this->form_field_callback = $args['display'];
        $this->save_term_callback = $args['save'];

        add_action("{$this->taxonomy->name}_edit_form_fields", [$this, 'edit_term_form_field'], null, 2);
        add_action("{$this->taxonomy->name}_add_form_fields", [$this, 'add_term_form_field'], null, 2);

        add_action("edited_{$this->taxonomy->name}", $this->save_term_callback, null, 2);
        add_action("create_{$this->taxonomy->name}", $this->save_term_callback, null, 2);
    }

    /**
     * hmmm
     */
    public function get_field_html()
    {
        $form_field = call_user_func($this->form_field_callback, $taxonomy, null);

        $this->field = new Form_Element($form_field['field']);
    }

    /**
     * 
     */
    public static function add_term_form_field($taxonomy)
    {
        $form_field = call_user_func($this->form_field_callback, $taxonomy, null);
        $form_field = apply_filters("backalley/{$this->taxonomy->name}_form_fields", $form_field, $taxonomy, null);

        $field = new Form_Element($form_field['field']);

        $form_field = [
            'container' => [
                'tag' => 'div',
                'attributes' => [
                    'class' => 'form-field',
                ],
                'children' => ['label', 'field', 'description'],
            ],
            'label' => [
                'tag' => 'label',
                'content' => $form_field['label'] ?? '',
                'attributes' => [
                    'for' => $form_field['field']['attributes']['id'] ?? ''
                ]
            ],
            'field' => $field->html,
            'description' => [
                'tag' => 'p',
                'content' => $form_field['description'] ?? '',
            ]
        ];

        $form_field = new HTML_Element($form_field);

        echo $form_field->html;
    }

    /**
     * 
     */
    public function edit_term_form_field($term, $taxonomy)
    {
        $form_field = call_user_func($this->form_field_callback, $taxonomy, $term);
        $form_field = apply_filters("backalley/{$this->taxonomy->name}_form_fields", $form_field, $taxonomy, $term);

        $field = new Form_Element($form_field['field']);

        $form_field = [
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
                'content' => $form_field['label'] ?? '',
                'attributes' => [
                    'for' => $form_field['field']['attributes']['id'] ?? ''
                ],
            ],
            'data' => [
                'tag' => 'td',
                'attributes' => [],
                'children' => ['field', 'description']
            ],
            'field' => $field->html,
            'description' => [
                'tag' => 'p',
                'content' => $form_field['description'],
                'attributes' => [
                    'class' => ['description']
                ]
            ]
        ];

        $form_field = new HTML_Element($form_field);

        echo $form_field->html;
    }
}
