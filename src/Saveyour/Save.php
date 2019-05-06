<?php

/**
 * @package Backalley
 */

namespace Backalley\Saveyour;

class Save
{
    /**
     * Save post meta
     */
    public static function post_meta($post_id, $meta_key, $value)
    {
        return Self::metadata('post', $post_id, $meta_key, $value);
    }

    /**
     * Save post meta
     */
    public static function term_meta($term_id, $meta_key, $value)
    {
        return Self::metadata('term', $post_id, $meta_key, $value);
    }

    /**
     * 
     */
    public static function metadata($type, $object_id, $meta_key, $value)
    {
        $old_data = get_metadata($type, $object_id, $meta_key, true);

        switch (true) {
            case is_null($value) || empty($value):
                delete_metadata($type, $object_id, $meta_key);
                break;

            case empty($old_data):
                add_metadata($type, $object_id, $meta_key, $value, true);
                break;

            default:
                update_metadata($type, $object_id, $meta_key, $value, $old_data);
        }
    }
}