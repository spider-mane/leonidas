<?php

namespace Backalley\DataFields;

use Backalley\GuctilityBelt;


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
     * Instantiate and return requested field 
     */
    public static function create($args)
    {
        $field = GuctilityBelt::arg_to_class($args['field'], "%sField", __NAMESPACE__);

        return new $field($args);
    }

    /**
     * Instantiate and return array of fields
     */
    public static function bulk_creation($fields)
    {
        foreach ($fields as $field => $args) {
            $fields[$field] = Self::generate($args);
        }
        return $fields;
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
        /**
         * call the function that is designated to handle processing each variable within the main post variable for the
         * metabox or post type. This establishes an implicit whitelist as only post variables that  correspond to a
         * save_{$variable} method will be processed
         * 
         * find a way to add more security layers to implicit whitelisting
         */
        foreach ($fields as $field) {
            $raw_data = $_POST[$field->name] ?? null;

            if (isset($raw_data)) {
                $field->save($post_id, $post, $update, null, $raw_data);
            }

            do_action("backalley/save/{$post->post_type}/{$field->name}", $post_id, $post, $update);
        }
    }
}
