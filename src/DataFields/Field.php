<?php

namespace Backalley\DataFields;


/**
 * 
 */
abstract class Field
{
    /**
     * list of post variables
     */
    public static $post_vars = [];

    /**
     * Instantiate and return requested field by parsing 
     */
    public static function generate($args)
    {
        $field = Self::arg_to_class($args['field']);

        return new $field($args);
    }

    /**
     * 
     */
    public static function render_all(object $object, array $fields)
    {
        $i = count($fields);

        foreach ($fields as $field) {
            $i--;

            $field->render($object);

            echo '<br>';

            if ($i > 0) {
                echo '<hr>';
            }
        }
    }

    /**
     * 
     */
    public static function save_all($post_id, $post, $update, array $fields)
    {
        foreach ($fields as $field) {
            $raw_data[$field['name']] = $_POST[$field['name']] ?? null;
        }

        /**
         * call the function that is designated to handle processing each variable within the main post variable for the
         * metabox or post type. This establishes an implicit whitelist as only post variables that  correspond to a
         * save_{$variable} method will be processed
         * 
         * find a way to add more security layers to implicit whitelisting
         */
        foreach ($raw_data as $fieldset => $value) {
            $save_fieldset = "save_{$fieldset}";
            // var_dump($fieldset);

            if (is_callable(['static', $save_fieldset])) {
                // var_dump($fieldset);
                static::$save_fieldset($post_id, $post, $update, $fieldset, $raw_data[$fieldset]);
            }

            do_action("backalley/save/{$post->post_type}/{$fieldset}", $post_id, $post, $update);
        }
    }

    /**
     * Convert custom argument to class format
     */
    public static function arg_to_class($arg, $class_format = '')
    {
        $bridge = str_replace('_', ' ', $arg);

        $bridge = ucwords($bridge);
        $bridge = str_replace(' ', '', $bridge);

        $class = __NAMESPACE__ . "\\{$bridge}Field";

        return $class;
    }

    public function api_example()
    {
        $fields = [
            'address' => [
                'field' => 'address_fieldset'
            ],
            'contact_info' => [
                'field' => 'fieldset',
                'fields' => [
                    'phone' => [
                        'label' => 'Phone',
                        'type' => 'phone',
                        'name' => 'contact_info__phone',
                        'id' => 'backalley--contact-info--phone',
                        'invalid' => 'Aye you better fix this'
                    ]
                ]
            ]
        ];
    }
}