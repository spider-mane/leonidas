<?php

/**
 * 
 */

namespace Backalley;

class GuctilityBelt
{
    /**
     * Convert custom argument to an FQN
     */
    public static function arg_to_class($arg, $class_format = '', $namespace = '')
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
    public static function one_versus_many($key, $fields)
    {
        if (array_key_exists($key, $fields)) {
            return [$fields];
        }
        return $fields;
    }

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
    public static function sort_objects_by_meta(array $objects, string $object_type, string $meta_key)
    {
        $order_array = [];

        $properties = Self::infer_object_properties($object_type, 'object_id');

        $object_id = $properties['object_id'];

        foreach ($objects as $object) {
            $order_array[$object->$object_id] = (int)get_metadata($object_type, $object->$object_id, $meta_key, true);
        }

        return Self::sort_objects_array($objects, $order_array, $object_id);
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

    /**
     * Borrowed from get name later,
     * needs to be modified to handle wider variety of objects
     */
    public static function sort_terms_hierarchicaly(array &$terms, array &$into, $parent_id = 0)
    {
        foreach ($terms as $index => $term) {
            if ($term->parent == $parent_id) {
                $into[$term->term_id] = $term;
                unset($terms[$index]);
            }
        }
        foreach ($into as $parent_term) {
            $parent_term->backalley->children = [];
            sort_terms_hierarchicaly($terms, $parent_term->backalley->children, $parent_term->term_id);
        }
    }

    /**
     * Takes a one dimensional array of wordpress hierarchical objects and
     * structures them hierachically. Care must be taken to pass an array of fully
     * cloned object if modifying the original objects is not the desired outcome.
     */
    public static function subjectify_wp_objects(array $wp_objects_array)
    {
        if (property_exists($wp_objects_array[0], 'term_id') && property_exists($wp_objects_array[0], 'taxonomy')) {
            $object_id = 'term_id';
            $parent = 'parent';
        } elseif (property_exists($wp_objects_array[0], 'ID') && property_exists($wp_objects_array[0], 'post_type')) {
            $object_id = 'ID';
            $parent = 'post_parent';
        }

        foreach ($wp_objects_array as $object) {
            if (!property_exists($object, 'parent')) {
                throw new Error('for this function to work, all terms in the array must have a parent property with a numerical value');
            }

            if (!property_exists($object, 'backalley')) {
                $object->backalley = new stdClass();
            }
        }

        foreach ($wp_objects_array as $object) {
            if (!empty($object->{$parent})) {
                foreach ($wp_objects_array as $potential_parent) {
                    if ($object->{$parent} === $potential_parent->{$object_id}) {
                        $potential_parent->backalley->children[] = $object;
                        break;
                    }
                }
            }
        }

        foreach ($wp_objects_array as $index => $object) {
            if (!empty($object->{$parent})) {
                unset($wp_objects_array[$index]);
            }
        }

        return $wp_objects_array;
    }

    /**
     *
     */
    public static function get_term_tier($term, $taxonomy, &$teir = 1)
    {
        $term = get_term_by('id', $term, $taxonomy, OBJECT);
    // $tier = 1;

        if (!empty($term->parent)) {
            $tier++;
            backalley_get_term_tier($term->parent, $taxonomy, $tier);
        }

        return $tier;
    }

    /**
     *
     */
    public static function get_object($object_array, $property_name, $property_value)
    {
        if (is_array($object_array) || is_string($property_name)) {
            return false;
        }

        foreach ($object_array ? : [] as $object) {
            if ($object->{$property_name} === $property_value) {
                return $object;
            }
        }

        return false;
    }

    /**
     *
     */
    public static function return_json($status)
    {
        $return = [
            'status' => $status,
        ];

        wp_send_json($return);

        wp_die();
    }

    /**
     *  function to verify nonce and user permissions to be called from each custom meta box with input fields
     */
    public static function verify_meta_box_nonce($nonce_name, $nonce_action)
    {
        $post = get_post();
        // Check that nonce field exists
        if (!isset($_POST[$nonce_name])) {
            return;
        }
        // Check that nonce has specified action
        if (!wp_verify_nonce($_POST[$nonce_name], $nonce_action)) {
            return;
        }
        // Prevent updating on autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        // Verify user permissions
        if (!current_user_can('edit_post', $post->ID)) {
            return;
        }
        return true;
    }

    /**
     * Send Request to google to geocode given address
     */
    public static function google_geocode(string $address, string $api_key)
    {
        if (empty($address)) {
            return '';
        }

        $address_url_formatted = urlencode($address);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address_url_formatted}&key={$api_key}";
        $resp = file_get_contents($url);
        $resp = json_decode($resp, true);

        if ($resp['status'] === 'OK') {
            $coord = isset($resp['results'][0]['geometry']['location']) ? $resp['results'][0]['geometry']['location'] : null;
            $coord = isset($coord) ? json_encode($coord) : null;

            return $coord;
        }
    }

    /**
     *
     */
    public static function concat_address($street, $city, $state, $zip)
    {
        if (!empty($street) && !empty($city) && !empty($state) && !empty($zip)) {
            return "${street}, ${city}, ${state} ${zip}";
        } else {
            return '';
        }
    }

    /**
     *
     */
    public static function json_encode($input, $slashes = true)
    {
        if ($slashes === true) {
            $input = wp_slash(json_encode($input, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        } elseif ($slashes === false) {
            $input = json_encode($input, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return $input;
    }

    /**
     *
     */
    public static function get_wp_option(string $option)
    {
        $option = get_option($option);
        $option = json_encode($option);

        return $option;
    }

    /**
     * UNDER CONSTRUCTION
     */
    public static function validate($thing, $value)
    {
        if ($thing === 'tel') {
            $regex = "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/";
        } elseif ($thing === 'price') {
            $regex = "/[0-9]{1}.^[0-9]{2}$/";
        }

        if (preg_match($regex, $value)) {
            return $value;
        } else {
            return false;
        }
    }
}
