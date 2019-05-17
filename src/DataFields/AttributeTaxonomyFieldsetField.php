<?php

/**
 * @package Backalley
 */

namespace Backalley\DataFields;

use Backalley\Saveyour;
use Backalley\Backalley;
use Backalley\GuctilityBelt;
use Backalley\Html\SelectOptions;
use Backalley\WP\MetaBox\PostMetaBoxFieldBaseTrait;

class AttributeTaxonomyFieldsetField extends FieldBase
{
    /**
     * meta_key_format
     * 
     * @var string
     */
    public $meta_key_format;

    /**
     * attribute_taxonomy
     * 
     * @var string
     */
    public $attribute_taxonomy;

    /**
     * input_type
     * 
     * @var string
     */
    public $input_type;

    /**
     * terms_title
     * 
     * @var string
     */
    public $terms_title;

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
        $this->attribute_taxonomy = $args['attribute_taxonomy'];
        $this->terms_title = $args['terms_title'] ?? null;
        $this->input_type = $args['input_type'];
        $this->meta_key_format = $args['meta_key_format'];
    }

    /**
     *
     */
    public function render($post)
    {
        if (empty($this->attribute_taxonomy)) {
            return;
        }

        $fields = [];

        $associated_attributes = get_the_terms($post->ID, $this->attribute_taxonomy) ? : [];

        $all_available_attributes = get_terms([
            'taxonomy' => $this->attribute_taxonomy,
            'hide_empty' => false
        ]);

        // create input for each associated attribute
        foreach ($associated_attributes as $attribute) {
            $slug = $attribute->slug;
            $title = htmlspecialchars_decode($attribute->name);

            $meta_key = "{$this->meta_prefix}{$post->post_type}_" . sprintf($this->meta_key_format, $slug);

            $fields[$slug] = [
                'title' => $title,
                'form_element' => 'input',
                'container_id' => "{$slug}--container",
                'attributes' => [
                    'type' => $this->input_type,
                    'id' => $this->id_prefix . $slug,
                    'name' => $this->name . "[{$slug}]",
                    'class' => 'large-text',
                    'value' => get_post_meta($post->ID, $meta_key, true),
                ],
                'wp_submit_button' => [
                    'text' => 'Remove',
                    'type' => 'delete small',
                    'name' => "{$slug}--delete",
                    'wrap' => false,
                    'other_attributes' => [
                        'data-attribute_id' => "{$slug}--container",
                    ]
                ]
            ];

            $fields[] = [
                'form_element' => 'input',
                'type' => 'hidden',
                'attributes' => [
                    'name' => "tax_input[{$this->attribute_taxonomy}][]",
                    'value' => $slug,
                    'id' => "ba--tax-input--$slug"
                ]

            ];
        }

        // // create templape for js dom manipulation
        // $fields['%attribute_name%'] = [
        //     'title' => '%attribute_title%',
        //     'form_element' => 'input',
        //     'container_id' => "backalley--attribute_url__%attribute_name%--container",
        //     'template' => true,
        //     'attributes' => [
        //         'type' => 'url',
        //         'value' => '',
        //         'class' => 'large-text',
        //         'data' => [
        //             "id-format=\"backalley--attribute_url__%attribute_name%--container\"",
        //         ],
        //         'disabled' => true,
        //         // 'hidden' => true,
        //     ],
        //     'wp_submit_button' => [
        //         'text' => 'Remove',
        //         'type' => 'delete small',
        //         'name' => "backalley--attribute_'%attribute_name%'--delete",
        //         'wrap' => false,
        //         'other_attributes' => [
        //             'data-backalley-location-attribute' => "backalley--attribute_url__{%attribute_name%}--container"
        //         ]
        //     ]
        // ];

        $list_items = [];

        // populate available attributes checklist items
        foreach ($all_available_attributes as $attribute) {

            $slug = $attribute->slug;
            $title = $attribute->name;

            if (in_array($attribute, $associated_attributes)) {
                continue;
            }

            $list_items[] = [
                'attributes' => [
                    'type' => 'checkbox',
                    'name' => "tax_input[{$this->attribute_taxonomy}][]",
                    'id' => $this->id_prefix . $slug,
                    'value' => $slug,
                ],
                'label' => [
                    'content' => $title,
                ]
            ];
        }

        // available attributes field
        if (!empty($all_available_attributes) && !empty($list_items)) {
            $fields[$this->attribute_taxonomy] = [
                'title' => $this->terms_title,
                'form_element' => 'checklist',
                'container' => [
                    'attributes' => [
                        'class' => 'thing'
                    ]
                ],
                'items' => $list_items ?? [],
            ];
        }
        

        // // new attribute field
        // $fields['new_attribute'] = [
        //     'form_element' => 'input',
        //     'title' => 'Add New attribute',
        //     'attributes' => [
        //         'type' => 'text',
        //     ]
        // ];

        $fieldset = [
            'fieldset_title' => $this->title,
            'fields' => $fields
        ];

        Self::metabox_fieldset_template($fieldset, 3);
    }

    /**
     *
     */
    public function save($post_id, $post, $update)
    {
        // terms will have been processed by this point, so even if a new attribute was added via post.php, it will be present
        $selected_attributes = wp_get_post_terms($post_id, $this->attribute_taxonomy);

        foreach ($selected_attributes as $index => $attribute) {
            $selected_attributes[$attribute->name] = $attribute->slug;
            unset($selected_attributes[$index]);
        }

        // sanitize data
        $new_attributes = filter_var_array(
            $_POST[$this->name] ?? [],
            FILTER_SANITIZE_URL
        );


        foreach ($new_attributes as $attribute => $value) {
            /*
             * If the attribute was newly added via the UI, the $attribute will correspond to the name value for the term
             * instead of the slug, use the selected_attributes array of name=>slug pairs in order to retrieve the slug
             * if $attribute does not correspond to a name, the term either existed prior to the page load or it is
             * invalid. The next step will deal with the latter possiblilty
             */
            $slug = $selected_attributes[htmlspecialchars($attribute)] ?? $attribute;

            
            /*
             * do not process anything that does not correspond to a term present in the selected_attributes
             * array any further
             */
            if (!in_array($slug, $selected_attributes)) {
                unset($new_attributes[$attribute]);
                continue;
            }

            /**
             * gather old data for comparison
             */
            $meta_key = "{$this->meta_prefix}{$post->post_type}_" . sprintf($this->meta_key_format, $slug);
            $old_data = get_post_meta($post_id, $meta_key, true);


            /**
             * update the value in the database if it has been changed.
             * 
             * if delete button was clicked, remove corresponding attribute from
             * the $new_attributes array and association with term
             */
            if ($value !== $old_data && !filter_has_var(INPUT_POST, "{$attribute}--delete")) {
                update_post_meta($post_id, $meta_key, $value);

            } elseif (filter_has_var(INPUT_POST, "{$attribute}--delete")) {
                delete_post_meta($post_id, $meta_key);
                wp_remove_object_terms($post_id, $slug, $this->attribute_taxonomy);
            }
        }
    }
}