<?php

namespace Leonidas\Library\Core\Helpers;

use Leonidas\Library\Core\Exceptions\ScriptNotRegisteredException;
use Leonidas\Library\Core\Exceptions\StyleNotRegisteredException;

function load_scripts(string ...$scripts): void
{
    foreach ($scripts as $script) {
        if (wp_script_is($script, 'registered')) {
            wp_enqueue_script($script);
        }

        throw new ScriptNotRegisteredException($script);
    }
}

function load_styles(string ...$styles): void
{
    foreach ($styles as $style) {
        if (wp_style_is($style, 'registered')) {
            wp_enqueue_style($style);
        }

        throw new StyleNotRegisteredException($style);
    }
}

function sort_objects_array(array $objects_array, array $order_array, string $order_key)
{
    usort($objects_array, function ($a, $b) use ($order_array, $order_key) {

        foreach ([$a, $b] as &$obj) {
            $obj = (int) $order_array[$obj->{$order_key}] >= 0 ? $order_array[$obj->{$order_key}] : 0;
        }

        if ($a === $b) {
            return 0;
        }

        if ($a < $b && $a === 0) {
            return 1;
        }

        if ($a > $b && $b === 0) {
            return -1;
        }

        return $a > $b ? 1 : -1;
    });

    return $objects_array;
}

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

function return_json($status)
{
    $return = [
        'status' => $status,
    ];

    wp_send_json($return);

    wp_die();
}

function json_encode_wp_safe($input, bool $slashes = true)
{
    $input = json_encode($input, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    if ($slashes) {
        $input = wp_slash($input);
    }

    return $input;
}
