<?php

/**
 * @package Backalley-Core
 *
 * Factory class to create field
 */

namespace Backalley\FormFields;

use Backalley\GuctilityBelt;
use Backalley\Html\TagSage;

class Factory
{
    /**
     * fields
     *
     * @var array
     */
    protected static $fields = [
        'input' => Input::class,
        'select' => Select::class,
        'textarea' => Textarea::class,
    ];

    /**
     *
     */
    public function __call($field, $args): FormFieldInterface
    {
        $class = GuctilityBelt::arg_to_class($field, "%s", __NAMESPACE__);

        if (class_exists($class)) {
            return new $class;
        } elseif (TagSage::is_it('standard_input_type', $field)) {
            return (new Input)->set_type($field);
        }

        return new Input();
    }

    /**
     *
     */
    public static function __callStatic($field, $args): FormFieldInterface
    {
        $field = GuctilityBelt::arg_to_class($field, "%s", __NAMESPACE__);

        if (class_exists($field)) {
            return $field::create(...$args);
        }
    }

    /**
     *
     */
    public function create($args): FormFieldInterface
    {
        $field = GuctilityBelt::arg_to_class($args['form_element'], '%s', __NAMESPACE__);

        return $field::create($args);
    }

    /**
     *
     */
    public static function registerField(string $name, string $field)
    {
        static::$fields[$name] = $field;
    }
}
