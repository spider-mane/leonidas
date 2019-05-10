<?php

namespace Backalley\DataFields;

use Backalley\Saveyour;
use Backalley\Backalley;


/**
 * @package Backalley
 */
class ReviewFieldsetField extends FieldBase
{
    /**
     * name
     * 
     * @var string
     */
    public $name = 'review';

    /**
     * title
     * 
     * @var string
     */
    public $title = 'Review';

    /**
     * id
     * 
     * @var string
     */
    public $id = 'backalley--review--fieldset';

    /**
     * subnames
     * 
     * @var array
     */
    public $subfields = [];

    /**
     * id_prefix
     * 
     * @var string
     */
    public $id_prefix = 'backalley--review--';

    /**
     * this->meta_prefix
     * 
     * @var string
     */
    public $meta_prefix;

    /**
     * 
     */
    public function __construct($args)
    {
        $this->name = $args['name'] ?? $this->name;
        $this->title = $args['title'] ?? $this->title;
        $this->id_prefix = $args['id_prefix'] ?? $this->id_prefix;
        $this->meta_prefix = $args['meta_prefix'] ?? Backalley::$meta_key_prefix;
    }

    /**
     * 
     */
    public function render($post)
    {
        $fields = [
            'subtitle' => [
                'title' => 'Subtitle',
                'form_element' => 'input',
                'attributes' => [
                    'type' => 'text',
                    'value' => get_post_meta($post->ID, "{$this->meta_prefix}{$post->post_type}_subtitle", true),
                ]
            ],
            'excerpt' => [
                'title' => 'Excerpt',
                'form_element' => 'textarea',
                // 'content' => get_post_field('excerpt', $post->ID, 'raw'),
                'content' => get_post_meta($post->ID, "{$this->meta_prefix}{$post->post_type}_excerpt", true),
                'attributes' => [
                    // 'id' => Self::$id_prefix . 'excerpt',
                    // 'class' => 'large-text',
                    'rows' => 5,
                    // 'name' => 'excerpt',
                ]
            ],
            'content' => [
                'title' => 'Content',
                'form_element' => 'textarea',
                'content' => get_post_meta($post->ID, "{$this->meta_prefix}{$post->post_type}_content", true),
                'attributes' => [
                    'rows' => 30
                ]
            ],
            'link' => [
                'title' => 'Link',
                'form_element' => 'input',
                'attributes' => [
                    'type' => 'url',
                    'value' => get_post_meta($post->ID, "{$this->meta_prefix}{$post->post_type}_link", true),
                ]
            ],
        ];

        foreach ($fields as $field => &$definiton) {
            $attributes = &$definiton['attributes'];

            // if ($field !== 'excerpt') {
            $attributes['name'] = $this->name . "[{$field}]";
            $attributes['id'] = $this->id_prefix . $field;
            $attributes['class'] = 'large-text';
            // }

            unset($definiton, $attributes);
        }

        $fieldset = [
            'fieldset_title' => 'Review',
            'fields' => $fields,
        ];

        Self::generate_fieldset($fieldset, 3);
    }

    /**
     * 
     */
    public function save($post_id, $post, $update, $fieldset = null, $raw_data = null)
    {
        $sanitized_data = [
            'subtitle' => [
                'filter' => FILTER_CALLBACK,
                'options' => 'sanitize_text_field'
            ],
            'excerpt' => [
                'filter' => FILTER_CALLBACK,
                'options' => 'sanitize_textarea_field'
            ],
            'content' => [
                'filter' => FILTER_CALLBACK,
                'options' => 'sanitize_textarea_field'
            ],
            'link' => [
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