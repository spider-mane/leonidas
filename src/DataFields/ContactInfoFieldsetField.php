<?php

namespace Backalley\DataFields;

use Backalley\Saveyour;
use Backalley\Backalley;


/**
 * @package Backalley
 */
class ContactInfoFieldsetField extends FieldBase
{
    /**
     * name
     * 
     * @var string
     */
    public $name = 'contact_info';

    /**
     * title
     * 
     * @var string
     */
    public $title = 'Contact Info';

    /**
     * id
     * 
     * @var string
     */
    public $id = 'backalley--contact_info--fieldset';

    /**
     * subnames
     * 
     * @var array
     */
    public $subnames = [];

    /**
     * id_prefix
     * 
     * @var string
     */
    public $id_prefix = 'backalley--contact_info--';

    /**
     * meta_prefix
     * 
     * @var string
     */
    public $meta_prefix;

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
            'phone' => [
                'attributes' => [
                    'type' => 'tel'
                ]
            ],
            'fax' => [
                'attributes' => [
                    'type' => 'tel'
                ]
            ],
            'email' => [
                'attributes' => [
                    'type' => 'email'
                ]
            ],
        ];

        foreach ($fields as $field => &$definition) {
            $definition['form_element'] = 'input';
            $definition['title'] = ucwords($field);

            $attrubutes = &$definition['attributes'];

            $attrubutes['value'] = get_post_meta($post->ID, "{$this->meta_prefix}{$post->post_type}_contact_info__{$field}", true) ?? '';
            $attrubutes['name'] = $this->name . "[$field]";
            $attrubutes['id'] = "{$this->id_prefix}--{$field}";
            $attrubutes['class'] = 'regular-text';
        }

        $fieldset = [
            'fieldset_title' => $this->title,
            'fields' => $fields
        ];

        Self::generate_fieldset($fieldset, 3);
    }

    /**
     *
     */
    public function save($post_id, $post, $update, $fieldset = null, $raw_data = null)
    {
        $instructions = [
            'phone' => [
                'check' => 'phone',
                'filter' => 'sanitize_text_field',
                'type' => 'post_meta',
                'item' => $post_id,
                'save' => $this->meta_prefix . "{$post->post_type}_contact_info__phone"
            ],
            'fax' => [
                'check' => 'phone',
                'filter' => 'sanitize_text_field',
                'type' => 'post_meta',
                'item' => $post_id,
                'save' => $this->meta_prefix . "{$post->post_type}_contact_info__fax"
            ],
            'email' => [
                'check' => 'email',
                'filter' => 'sanitize_email',
                'type' => 'post_meta',
                'item' => $post_id,
                'save' => $this->meta_prefix . "{$post->post_type}_contact_info__email"
            ],
        ];

        $results = Saveyour::judge($instructions, $raw_data);
    }
}