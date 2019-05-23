<?php

namespace Backalley\Wordpress\Fields;

use Backalley\Backalley;
use Backalley\WordPress\Term\TermFieldBaseTrait;
use Backalley\WordPress\MetaBox\PostMetaBoxFieldBaseTrait;


/**
 * @package Backalley
 */
class InputField extends FieldBase
{
    /**
     * type
     * 
     * @var string
     */
    public $type = 'text';

    /**
     * placeholder
     * 
     * @var string
     */
    public $placeholder;

    // use TermFieldBaseTrait;
    // use PostMetaBoxFieldBaseTrait;

    /**
     * 
     */
    public function __construct($args)
    {
        parent::__construct($args);
        $this->type = $args['type'] ?? $this->type;
    }

    /**
     * 
     */
    public function render($post)
    {
        $input = [
            'title' => $this->title,
            'description' => $this->description,
            'form_element' => 'input',
            'attributes' => array_merge($this->attributes, [
                'value' => $this->get_data($post),
                'type' => $this->type,
                'class' => array_merge($this->attributes['class'] ?? [], [
                    $this->width
                ]),
            ])
        ];

        $fieldset = [
            'fieldset_title' => $this->title,
            'fields' => $input
        ];

        Self::metabox_fieldset_template($fieldset, 3);
    }

    /**
     * 
     */
    public function render_add_term_form_field($taxonomy)
    {
        $input = [
            'title' => $this->title,
            'description' => $this->description,
            'form_element' => 'input',
            'attributes' => array_merge($this->attributes, [
                'id' => $this->id,
                'name' => $this->name,
                'type' => $this->type,
            ])
        ];

        Self::add_term_form_field_template($select);
    }

    /**
     * 
     */
    public function render_edit_term_form_field($term, $taxonomy)
    {
        $input = [
            'title' => $this->title,
            'description' => $this->description,
            'form_element' => 'input',
            'attributes' => array_merge($this->attributes, [
                'id' => $this->id,
                'name' => $this->name,
                'type' => $this->type,
                'value' => $this->value ?? get_term_meta($term->term_id, $this->meta_prefix . $this->meta_key, true),
            ])
        ];

        Self::edit_term_form_field_template($select);
    }
}