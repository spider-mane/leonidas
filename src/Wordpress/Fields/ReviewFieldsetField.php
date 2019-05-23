<?php

namespace Backalley\Wordpress\Fields;

use Backalley\Saveyour;
use Backalley\Backalley;
use Backalley\WordPress\MetaBox\PostMetaBoxFieldBaseTrait;


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
     * id_prefix
     * 
     * @var string
     */
    public $id_prefix = 'backalley--review--';

    /**
     * subnames
     * 
     * @var array
     */
    public $fields = [];

    use PostMetaBoxFieldBaseTrait;

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

        Self::metabox_fieldset_template($fieldset, 3);
    }

    /**
     * 
     */
    public function save($post_id, $post, $update)
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

        $sanitized_data = filter_var_array($_POST[$this->name], $sanitized_data);

        foreach ($sanitized_data as $field => $new_data) {
            $meta_key = "{$this->meta_prefix}{$post->post_type}_{$field}";
            $old_data = get_post_meta($post_id, $meta_key, true);

            if ($old_data !== $new_data) {
                update_post_meta($post_id, $meta_key, $new_data);
            }
        }
    }
}