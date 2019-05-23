<?php

namespace Backalley\Wordpress\Fields;

use Backalley\Backalley;
use Backalley\WordPress\Term\TermFieldBaseTrait;
use Backalley\WordPress\MetaBox\PostMetaBoxFieldBaseTrait;


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
            'content' => $this->get_data($post),
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