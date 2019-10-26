<?php

namespace WebTheory\Leonidas\Helpers;

/**
 *
 */
function sort_objects_by_meta(array $objects, string $object_type, string $meta_key)
{
    $order_array = [];

    $properties = infer_object_properties($object_type, 'object_id');

    $object_id = $properties['object_id'];

    foreach ($objects as $object) {
        $order_array[$object->$object_id] = (int) get_metadata($object_type, $object->$object_id, $meta_key, true);
    }

    return sort_objects_array($objects, $order_array, $object_id);
}

/**
 *
 */
function infer_object_properties($object_type, $properties = null)
{
    switch ($object_type) {
        case 'post':
            $object_id = 'ID';
            $object_parent = 'post_parent';
            break;
        case 'term':
            $object_id = 'term_id';
            $object_parent = 'parent';
            break;
    }

    return ['object_id' => $object_id, 'object_parent' => $object_parent];
}

/**
 *
 */
function return_json($status)
{
    $return = [
        'status' => $status,
    ];

    wp_send_json($return);

    wp_die();
}

/**
 *
 */
function safe_save_post($post, $nonce, $action)
{
    $unsafe_conditions = [

        !isset($_POST[$nonce]), // nonce field does not exist

        !wp_verify_nonce($_POST[$nonce], $action), // nonce action does not match

        defined('DOING_AUTOSAVE') && DOING_AUTOSAVE, // wp performing autosave

        !current_user_can('edit_post', $post->ID) // current user does not have required permission
    ];

    foreach ($unsafe_conditions as $condition) {
        if ((bool) $condition) return false;
    }

    return true;
}

/**
 *
 */
function json_encode_wp_safe($input, bool $slashes = true)
{
    $input = json_encode($input, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    if ($slashes) {
        $input = wp_slash($input);
    }

    return $input;
}
