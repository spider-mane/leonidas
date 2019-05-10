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
     * current_context
     * 
     * @var array
     */
    public $context;

    /**
     * 
     */
    public function __construct($args)
    {
        parent::__construct($args);
        $this->relatable_post_type = $args['relatable'];
        $this->related_post_type = $args['related'];
        $this->connection = $args['connection'] ?? "_{$this->relatable_post_type}_";
    }

    /**
     * 
     */
    public function render($post)
    {
        $this->set_context($post);

        $items = get_posts([
            'post_type' => $this->context === 'relatable' ? $this->related_post_type : $this->relatable_post_type,
            'numberposts' => -1,
            'orderby' => 'name'
        ]);

        $list_items = [];

        foreach ($items as $item) {
            if ($this->context === 'relatable') {
                $name = $this->name . "[{$item->ID}]";
                $checked = has_term("{$post->ID}", $this->connection, $item->ID) ? true : false;
                $value = '1';
            } else {
                $name = "tax_input[{$this->connection}][]";
                $checked = has_term("{$item->ID}", $this->connection, $post->ID) ? true : false;
                $value = $item->ID;
            }

            $list_items[] = [
                'attributes' => [
                    'name' => $name,
                    'id' => $this->id_prefix . $item->post_name,
                    'checked' => $checked,
                    'value' => $value,
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
    public function save($post_id, $post, $update, $fieldset = null, $raw_data = null)
    {
        $related_posts = filter_var(
            $raw_data,
            FILTER_CALLBACK,
            ['options' => $this->filter]
        );

        $post_as_term = strval($post_id);

        foreach ($related_posts as $related_post => $selected) {
            if ($selected) {
                /* 
                 * do not under any circunstances modify 4th argument. it must be set to true 
                 * in order to prevent completely rewriting terms of the related post
                 */
                wp_set_object_terms($related_post, $post_as_term, $this->connection, true);
            } elseif (!$selected) {
                wp_remove_object_terms($related_post, $post_as_term, $this->connection);
            }
        }
    }

    /**
     * 
     */
    public function set_context($post)
    {
        $this->context = $post->post_type === $this->related_post_type ? 'related' : 'relatable';
    }
}