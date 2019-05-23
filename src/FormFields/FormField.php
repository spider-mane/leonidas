<?php

/**
 * @package Backalley-Core
 * 
 * Simple factory to generate field
 */

namespace Backalley\FormFields;

use Backalley\Html\TagSage;
use Backalley\GuctilityBelt;
use Backalley\Html\HtmlConstructor;
use function Respect\Validation\Rules\class_exists;


abstract class FormField extends HtmlConstructor
{
    /**
     * 
     */
    public $attributes = [];

    /**
     *
     */
    final public function __construct($args = null, $charset = null)
    {
        parent::__construct($args, $charset);
        $this->parse_args($args);
    }

    /**
     * 
     */
    public static function __callStatic($field, $args)
    {
        $field = GuctilityBelt::arg_to_class($field, "%s", __NAMESPACE__);

        if (class_exists($field)) {
            return new $field(...$args);
        }
    }

    /**
     * 
     */
    public static function create($args)
    {
        $field = GuctilityBelt::arg_to_class($args['form_element'], '%s', __NAMESPACE__);

        return $field::create($args);
    }
}
