<?php

namespace Backalley\GuctilityBelt;

/**
 * Convert custom argument to an FQN
 */
function arg_to_class($arg, $class_format = '', $namespace = '')
{
    $bridge = str_replace('_', ' ', $arg);

    $bridge = ucwords($bridge);
    $bridge = str_replace(' ', '', $bridge);

    $class = $namespace . "\\" . sprintf($class_format, $bridge);

    return $class;
}

/**
 *
 */
function one_versus_many($key, $fields)
{
    if (array_key_exists($key, $fields)) {
        return [$fields];
    }
    return $fields;
}

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

/**
 *
 */
function get_object($object_array, $property_name, $property_value)
{
    if (is_array($object_array) || is_string($property_name)) {
        return false;
    }

    foreach ($object_array ?: [] as $object) {
        if ($object->{$property_name} === $property_value) {
            return $object;
        }
    }

    return false;
}

/**
 * Send Request to google to geocode given address
 *
 * @param string $address
 * @param string $key Google Maps api key
 */
function google_geocode(string $address, string $key)
{
    $address = urlencode($address);

    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$key}";

    $response = json_decode(file_get_contents($url), true);

    if ('OK' === $response['status']) {
        $coordinates = $response['results'][0]['geometry']['location'];

        return json_encode($coordinates);
    }
}

/**
 *
 */
function address_format($street, $city, $state, $zip)
{
    return "${street}, ${city}, ${state} ${zip}";
}
