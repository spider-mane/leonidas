<?php

/**
 * @package Backalley
 */

namespace Backalley\DataFields;

use Backalley\Backalley;


class PostRelationshipChecklistField extends FieldBase
{
    /**
     * relatable_post_type
     * 
     * @var array
     */
    public $relatable_post_type = [];

    /**
     * related_post_type
     * 
     * @var array
     */
    public $related_post_type = [];

    /**
     * connection
     * 
     * @var array
     */
    public $connection = [];

    /**
     * 
     */
    public function __construct($args)
    {
        $this->relatable_post_type = $args['relatable'];
        $this->related_post_type = $args['related'];
        $this->connection = $args['connection'];
        $this->name = $args['name'] ?? $this->name;
        $this->title = $args['title'] ?? $this->title;
        $this->id = $args['id'] ?? $this->title;
        $this->id_prefix = $args['id_prefix'] ?? $this->id_prefix;
        $this->meta_prefix = $args['meta_prefix'] ?? Backalley::$meta_key_prefix;
    }

    /**
     * 
     */
    public function render($post)
    {
        if ($post->post_type === $this->related_post_type) {
            $posts = $this->relatable_post_type;
            $context = 'related';
        } else {
            $posts = $this->related_post_type;
            $context = 'relatable';
        }

        $items = get_posts([
            'post_type' => $posts,
            'numberposts' => -1,
            'orderby' => 'name'
        ]);

        $list_items = [];

        foreach ($items as $item) {
            $list_items[] = [
                'attributes' => [
                    'name' => $context === 'relatable' ? $this->name . "[{$item->ID}]" : "tax_input[{$this->connection}][]",
                    'id' => $this->id_prefix . 'menu-item--' . $item->post_name,
                    'checked' => has_term("{$post->ID}", $this->connection, $item->ID) ? true : false,
                    'value' => '1',
                ],

                'label' => [
                    'content' => $item->post_title,
                ],
            ];
        }

        $checklist = [
            'title' => $this->title,
            'form_element' => 'checklist',
            'toggle' => true,
            'container' => [
                'attributes' => [
                    'id' => $this->id ?? '',
                    'class' => 'thing'
                ]
            ],
            'ul' => [
                'attributes' => []
            ],
            'items' => $list_items,
        ];

        $fieldset = [
            'fieldset_title' => 'Available Menu Items',
            'fields' => $checklist
        ];

        Self::generate_fieldset($fieldset, 3);
    }

    /**
     * 
     */
    public function get_relationship_context($post_type)
    {
        //
    }

    /**
     * 
     */
    public function save($post_id, $post, $update, $fieldset = null, $raw_data = null)
    {
        $related_posts = filter_var(
            $raw_data,
            FILTER_CALLBACK,
            ['options' => 'sanitize_text_field']
        );

        $post_as_term = strval($post_id);

        foreach ($related_posts as $related_post => $selected) {
            if ($selected) {
                /* 
                 * do not under any circunstances modify 4th argument. it must be set to true 
                 * in order to prevent completely rewriting terms of menu item
                 */
                wp_set_object_terms($related_post, $post_as_term, $this->connection, true);
            } elseif (!$selected) {
                wp_remove_object_terms($related_post, $post_as_term, $this->connection);
            }
        }
    }
}