<?php

/**
 * @package Backalley
 */

namespace Backalley\DataFields;

use Backalley\Backalley;
use Backalley\WP\MetaBox\PostMetaBoxFieldBaseTrait;


class PostRelationshipChecklistField extends FieldBase
{
    /**
     * relatable_post_type
     * 
     * @var string
     */
    public $relatable_post_type;

    /**
     * related_post_type
     * 
     * @var string
     */
    public $related_post_type;

    /**
     * connection
     * 
     * @var string
     */
    public $connection;

    /**
     * current_context
     * 
     * @var string
     */
    public $context;

    // use PostMetaBoxFieldBaseTrait;

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
                    'id' => $this->id_prefix . $item->post_name,
                    'name' => $name,
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
            'clear_control' => $this->context === 'related' ? ["tax_input[{$this->connection}][]", '0'] : null,
            'toggle' => $this->context === 'relatable' ? '0' : null,
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

        Self::metabox_fieldset_template($fieldset, 3);
    }

    /**
     * 
     */
    public function save($post_id, $post, $update)
    {
        $related_posts = filter_var(
            $_POST[$this->name],
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