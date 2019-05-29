<?php

/**
 * @package Backalley-Core
 * 
 * Factory class to create field
 */

namespace Backalley\FormFields;

use Backalley\GuctilityBelt;


class FormField
{
    /**
     * 
     */
    public static function __callStatic($field, $args) : FormFieldInterface
    {
        $field = GuctilityBelt::arg_to_class($field, "%s", __NAMESPACE__);

        if (class_exists($field)) {
            return new $field(...$args);
        }
    }

    /**
     * 
     */
    public static function create($args) : FormFieldInterface
    {
        $field = GuctilityBelt::arg_to_class($args['form_element'], '%s', __NAMESPACE__);

        return $field::create($args);
    }
}
