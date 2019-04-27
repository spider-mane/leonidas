<?php

/**
 * 
 */


class Guctility_Belt
{
    /**
     * 
     */
    public static function sort_objects_array(array $objects_array, array $order_array, string $order_key)
    {
        usort($objects_array, function ($a, $b) use ($order_array, $order_key) {

            foreach ([&$a, &$b] as &$obj) {
                $obj = (int)$order_array[$obj->{$order_key}] >= 0 ? $order_array[$obj->{$order_key}] : 0;
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

    /**
     * 
     */
    public static function sort_objects_by_meta(array $objects, string $object_type, string $metter_key)
    {
        $order_array = [];

        $properties = Self::infer_object_properties($object_type, 'object_id');

        $object_id = $properties['object_id'];

        foreach ($objects as $object) {
            $order_array[$object->$object_id] = (int)get_metadata($object_type, $object->$object_id, $metter_key, true);
        }

        return Guctility_Belt::sort_objects_array($objects, $order_array, $object_id);
    }

    /**
     * 
     */
    public static function infer_object_properties($object_type, $properties = null)
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
}
