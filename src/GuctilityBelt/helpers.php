<?php

namespace WebTheory\GuctilityBelt;

/**
 *
 */
function sort_objects_array(array $objects_array, array $order_array, string $order_key)
{
    usort($objects_array, function ($a, $b) use ($order_array, $order_key) {

        foreach ([&$a, &$b] as &$obj) {
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
