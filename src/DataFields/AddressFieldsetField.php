<?php

/**
 * @package Backalley
 */

namespace Backalley\DataFields;

use Backalley\Saveyour;
use Backalley\Backalley;
use Backalley\GuctilityBelt;
use Backalley\Html\SelectOptions;

class AddressFieldsetField extends FieldBase
{
    /**
     * name
     * 
     * @var string
     */
    public $name = 'address';

    /**
     * id
     * 
     * @var string
     */
    public $id = 'backalley--address--fieldset';

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
    public $id_prefix = 'backalley--address--';

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
        $post_id = $post->ID;

        $fields = [
            'street' => [],
            'city' => [],
            'state' => [
                'form_element' => 'select',
                'options' => array_merge(['' => 'Select State'], SelectOptions::us_states()),
                'selected' => get_post_meta($post_id, $this->meta_prefix . "{$post->post_type}_address__state", true)
            ],
            'zip' => [],
            'complete' => [
                'attributes' => [
                    'disabled' => true
                ]
            ],
            'geo' => [
                'attributes' => [
                    'disabled' => true
                ]
            ],
        ];

        foreach ($fields as $field => &$definition) {
            $definition['title'] = ucwords(str_replace('_', ' ', $field));

            // add attributes array if not there
            if (!array_key_exists('attributes', $definition)) {
                $definition['attributes'] = [];
            }
            $attributes = &$definition['attributes'];

            if ($field !== 'state') {
                $definition['form_element'] = 'input';
                $attributes['type'] = 'text';
                $attributes['value'] = get_post_meta($post_id, $this->meta_prefix . "{$post->post_type}_address__{$field}", true) ?? '';
            }

            $attributes['name'] = "{$this->name}[$field]";
            $attributes['id'] = "{$this->id_prefix}--{$field}";
            $attributes['class'] = 'regular-text';

            // make json stored data presentable
            if ($field === 'geo' && !empty($attributes['value'])) {
                $attributes['value'] = htmlspecialchars($attributes['value']);
            }
        }

        $fieldset = [
            'fieldset_title' => 'Address',
            'fields' => $fields
        ];

        Self::generate_fieldset($fieldset, 3);
    }

    /**
     *
     */
    public function save($post_id, $post, $update, $fieldset = null, $raw_data = null)
    {
        $updated = false;
        $post_type = $post->post_type;
        $meta_prefix = Backalley::$meta_key_prefix;

        $instructions = [
            'street' => [],
            'city' => [],
            'state' => [],
            'zip' => [],
        ];

        foreach ($instructions as $field => &$rules) {
            $rules['filter'] = 'sanitize_text_field';
            $rules['type'] = 'post_meta';
            $rules['item'] = $post_id;
            $rules['save'] = $meta_prefix . "{$post->post_type}_address__{$field}";
        }

        $results = Saveyour::judge($instructions, $raw_data);

        // Save fully formatted address and geo coordinates retrieved from google
        foreach ($results->revelations as $revelations) {
            if ($revelations['updated'] === true) {

                $complete_address = GuctilityBelt::concat_address(
                    $results->revelations['street']['value'],
                    $results->revelations['city']['value'],
                    $results->revelations['state']['value'],
                    $results->revelations['zip']['value']
                );

                update_post_meta($post_id, $meta_prefix . "{$post_type}_address__complete", $complete_address);

                if (isset(Backalley::$api_keys['google_maps'])) {
                    $coordinates = GuctilityBelt::google_geocode($complete_address, Backalley::$api_keys['google_maps']);
                    update_post_meta($post_id, "{$post_type}_address__geo", $coordinates);
                }

                break;
            }
        }
    }
}