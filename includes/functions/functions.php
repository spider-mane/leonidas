<?php

use function DeepCopy\deep_copy;

function sort_terms_hierarchicaly(array &$terms, array &$into, $parent_id = 0)
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
function backalley_subjectify_wp_objects(array $wp_objects_array)
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
function backalley_get_term_tier($term, $taxonomy, &$teir = 1)
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
function backalley_get_object($object_array, $property_name, $property_value)
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
 *
 */
function backalley_return_json($status)
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
function backalley_verify_meta_box_nonce($nonce_name, $nonce_action)
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
function backalley_request_google_geocode(string $address, string $api_key)
{
    if (empty($address)) {
        return '';
    }

    $address_url_formatted = urlencode($address);
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address_url_formatted . '&key=' . $api_key;
    $resp_json = file_get_contents($url);
    $resp = json_decode($resp_json, true);

    if ($resp['status'] === 'OK') {
        $coord = isset($resp['results'][0]['geometry']['location']) ? $resp['results'][0]['geometry']['location'] : null;
        $coord = isset($coord) ? json_encode($coord) : null;

        return $coord;
    }
}

/**
 *
 */
function backalley_concat_address($street, $city, $state, $zip)
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
function backalley_json_encode($input, $slashes = true)
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
function backalley_get_wp_option(string $option)
{
    $option = get_option($option);
    $option = json_encode($option);

    return $option;
}

/**
 * UNDER CONSTRUCTION
 */
function backalley_validate($thing, $value)
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
