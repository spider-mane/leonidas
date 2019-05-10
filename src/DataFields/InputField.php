<?php

namespace Backalley\DataFields;

use Backalley\Backalley;


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
            'form_element' => 'input',
            'attributes' => array_merge($this->attributes, [
                'id' => $this->id,
                'name' => $this->name,
                'type' => $this->type,
                'value' => get_post_meta($post->ID, $this->meta_prefix . "{$post->post_type}_{$this->meta_key}", true),
                'class' => array_merge($this->attributes['class'] ?? [], [
                    $this->width
                ]),
            ])
        ];

        $fieldset = [
            'fieldset_title' => $this->title,
            'fields' => $input
        ];

        Self::generate_fieldset($fieldset, 3);
    }
}