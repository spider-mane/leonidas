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
        $old_data = get_post_meta($post_id, $meta_key, true);

        // var_dump($meta_key, $value);

        switch (true) {
            case is_null($value) || empty($value):
                delete_post_meta($post_id, $meta_key);
                break;

            case empty($old_data):
                add_post_meta($post_id, $meta_key, $value, true);
                break;

            default:
                update_post_meta($post_id, $meta_key, $value, $old_data);
        }
    }
}