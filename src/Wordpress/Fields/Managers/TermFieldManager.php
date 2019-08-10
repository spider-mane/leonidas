<?php

namespace Backalley\WordPress\Fields\Managers;

use Backalley\Html\Html;
use Backalley\Html\Element;
use Backalley\DataFields\FieldBase;
use Backalley\FormFields\FormField;


class TermFieldManager
{
    /**
     *
     */
    public $field;

    /**
     *
     */
    public function __construct($field)
    {
        $this->field = $field;
    }

    /**
     *
     */
    public function render_add_term_form_field($taxonomy)
    {
        Self::add_term_form_field_template($this->field->generate_field());
    }

    /**
     *
     */
    public function render_edit_term_form_field($term, $taxonomy)
    {
        Self::edit_term_form_field_template($this->field->generate_field($term));
    }

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
        $field = Element::create([
            'root' => [
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

        echo $field;
    }

    /**
     *
     */
    public static function edit_term_form_field_template($field)
    {
        $field = Element::create([
            'root' => [
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

        echo $field;
    }

    /**
     *
     */
    public function get_data($term)
    {
        return get_term_meta($term->term_id, $this->field->meta_prefix . $this->field->meta_key, true);
    }

    /**
     *
     */
    public function save_term_field($term_id, $tt_id)
    {
        if (!filter_has_var(INPUT_POST, $this->field->name)) {
            return;
        }

        $instructions = [
            'filter' => !empty($this->field->filter) ? $this->field->filter : 'sanitize_text_field',
            'check' => !empty($this->field->validation) ? $this->field->validation : null,
            'type' => 'term_meta',
            'item' => $term_id,
            'save' => "{$this->field->meta_prefix}{$post->post_type}_{$this->field->meta_key}"
        ];

        $results = Saveyour::judge($instructions, $_POST[$this->field->name]);
    }
}
