<?php

namespace Backalley\DataFields;

use Backalley\Backalley;
use Backalley\WP\MetaBox\PostMetaBoxFieldBaseTrait;


/**
 * @package Backalley
 */
class TextareaField extends FieldBase
{
    /**
     * filter
     * 
     * @var string
     */
    public $filter = 'sanitize_textarea_field';

    /**
     * content
     * 
     * @var string
     */
    public $content;

    /**
     * 
     */
    public function render($post)
    {
        $textarea = [
            'title' => $this->title,
            'form_element' => 'textarea',
            'content' => get_post_meta($post->ID, $this->meta_prefix . "{$post->post_type}_{$this->meta_key}", true),
            'attributes' => array_merge($this->attributes, [
                'id' => $this->id,
                'name' => $this->name,
                'class' => array_merge($this->attributes['class'] ?? [], [
                    $this->width
                ]),
            ])
        ];

        $fieldset = [
            'fieldset_title' => $this->title,
            'fields' => $textarea
        ];

        Self::metabox_fieldset_template($fieldset, 3);
    }
}