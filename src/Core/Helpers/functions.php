<?php

namespace WebTheory\Leonidas\Core\Helpers;

use function WebTheory\GuctilityBelt\sort_objects_array;

/**
 * Returns the exact version string passed if SCRIPT_DEBUG is undefined or set
 * to false or unix timestamp if it's set to true. Useful to prevent browser
 * using cached scripts and stylesheets during development.
 *
 * @param string $version Actual version of the asset
 *
 * @return string|int
 */
function deversion(string $version)
{
    return (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? time() : $version;
}

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
function infer_object_properties($object_type)
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
function json_encode_wp_safe($input, bool $slashes = true)
{
    $input = json_encode($input, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    if ($slashes) {
        $input = wp_slash($input);
    }

    return $input;
}
