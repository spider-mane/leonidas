<?php

namespace Backalley\WordPress\Term;

use Backalley\DataFields\FieldBase;
use Backalley\FormFields\FormField;
use Backalley\Html\Html;


trait TermFieldBaseTrait
{
    /**
     * 
     */
    public static function term_field_template($field)
    {
        switch (get_current_screen()->base) {
            case 'term':
                Self::add_term_form_field_template($field);

            case 'edit-tags':
                Self::add_term_form_field_template($field);
        }
    }

    /**
     * 
     */
    public static function add_term_form_field_template($field)
    {
        $form_field = new Html([
            'container' => [
                'tag' => 'div',
                'attributes' => [
                    'class' => 'form-field',
                ],
                'children' => ['label', 'field', 'description'],
            ],
            'label' => [
                'tag' => 'label',
                'content' => $field['title'] ?? '',
                'attributes' => [
                    'for' => $field['attributes']['id'] ?? ''
                ],
            ],
            'field' => FormField::create($field),
            'description' => [
                'tag' => 'p',
                'content' => $field['description'] ?? '',
            ]
        ]);

        echo $form_field->html;
    }

    /**
     * 
     */
    public static function edit_term_form_field_template($field)
    {
        $form_field = new Html([
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
                'content' => $field['title'] ?? '',
                'attributes' => [
                    'for' => $field['attributes']['id'] ?? ''
                ],
            ],
            'data' => [
                'tag' => 'td',
                'attributes' => [],
                'children' => ['field', 'description']
            ],
            'field' => FormField::create($field),
            'description' => [
                'tag' => 'p',
                'content' => $field['description'] ?? '',
                'attributes' => [
                    'class' => ['description']
                ]
            ]
        ]);

        echo $form_field->html;
    }

    /**
     * 
     */
    public function get_dataa($term)
    {
        return get_term_meta($term->term_id, $this->meta_prefix . $this->meta_key, true);
    }

    /**
     * 
     */
    public function save_term_field($term_id, $tt_id)
    {
        if (!filter_has_var(INPUT_POST, $this->name)) {
            return;
        }

        $instructions = [
            'filter' => !empty($this->filter) ? $this->filter : 'sanitize_text_field',
            'check' => !empty($this->validation) ? $this->validation : null,
            'type' => 'term_meta',
            'item' => $term_id,
            'save' => "{$this->meta_prefix}{$post->post_type}_{$this->meta_key}"
        ];

        $results = Saveyour::judge($instructions, $_POST[$this->name]);
    }
}