<?php

namespace Backalley\DataFields;

use Backalley\Saveyour;
use Backalley\Backalley;


/**
 * @package Backalley
 */
class PublicationInfoFieldsetField extends FieldBase
{
    /**
     * name
     * 
     * @var string
     */
    public $name = 'publication_info';

    /**
     * title
     * 
     * @var string
     */
    public $title = 'Publication Info';

    /**
     * id
     * 
     * @var string
     */
    public $id = 'backalley--publication_info--fieldset';

    /**
     * id_prefix
     * 
     * @var string
     */
    public $id_prefix = 'backalley--publication_info--';

    /**
     * subnames
     * 
     * @var array
     */
    public $fields = [];

    /**
     * 
     */
    public function __construct($args)
    {
        parent::__construct($args);
    }

    /**
     * 
     */
    public function render($post)
    {
        $fields = [
            'publication' => [
                'title' => 'Publication',
                'form_element' => 'input',
                'attributes' => [
                    'type' => 'text',
                    'class' => 'regular-text'
                ]
            ],
            'date_published' => [
                'title' => 'Date Published',
                'form_element' => 'input',
                'attributes' => [
                    'type' => 'date'
                ]
            ],
            'author' => [
                'title' => 'Review Author',
                'form_element' => 'input',
                'attributes' => [
                    'type' => 'text',
                    'class' => 'regular-text'
                ]
            ],
        ];

        foreach ($fields as $field => &$info) {
            $attributes = &$info['attributes'];

            $attributes['value'] = get_post_meta($post->ID, "{$this->meta_prefix}{$post->post_type}_{$field}", true);
            $attributes['name'] = $this->name . "[{$field}]";
            $attributes['id'] = $this->id_prefix . $field;
        }

        $fieldset = [
            'fieldset_title' => "Publication Info",
            'fields' => $fields
        ];

        Self::generate_fieldset($fieldset, 3);
    }

    /**
     * 
     */
    public function save($post_id, $post, $update, $fieldset = null, $raw_data = null)
    {
        $sanitized_data = [
            'publication' => [
                'filter' => FILTER_CALLBACK,
                'options' => 'sanitize_text_field'
            ],
            'date_published' => [
                'filter' => FILTER_CALLBACK,
                'options' => 'sanitize_text_field'
            ],
            'author' => [
                'filter' => FILTER_CALLBACK,
                'options' => 'sanitize_text_field'
            ],
        ];

        foreach ($sanitized_data as $field => &$args) {
            $args['options'] = apply_filters("backalley/sanitize/press_review/{$field}", $args['options']);
        }

        $sanitized_data = filter_var_array($raw_data, $sanitized_data);

        foreach ($sanitized_data as $field => $new_data) {
            $meta_key = "{$this->meta_prefix}{$post->post_type}_{$field}";
            $old_data = get_post_meta($post_id, $meta_key, true);

            if ($old_data !== $new_data) {
                update_post_meta($post_id, $meta_key, $new_data);
            }
        }
    }
}