<?php

namespace Backalley\FormFields;

use Backalley\Html\TagSage;
use Backalley\GuctilityBelt;


class Input extends FormField implements FormFieldInterface
{
    /**
     * 
     */
    public $type = 'text';

    /**
     * 
     */
    public $name;

    /**
     * 
     */
    public $value;

    // use SingleValueTrait;

    /**
     * 
     */
    public function __toString()
    {
        $this->attributes['value'] = $this->value;
        $this->attributes['type'] = $this->type;
        $this->attributes['name'] = $this->name;

        return $this->open('input', $this->attributes);
    }

    /**
     * 
     */
    public function parse_args($args)
    {
        $this->attributes = $args['attributes'] ?? $this->attributes;
        $this->type = $args['type'] ?? $this->attributes['type'] ?? $this->type;
        $this->name = $args['name'] ?? $this->attributes['name'] ?? $this->name;
        $this->value = $args['value'] ?? $this->attributes['value'] ?? $this->value;
    }

    /**
     * 
     */
    public static function create($args)
    {
        $type = $args['type'] ?? $args['attributes']['type'] ?? 'text';

        if (TagSage::is_it('standard_input_type', $type)) {
            return new Input($args);

        } else {
            $type = GuctilityBelt::arg_to_class($type, '%s', __NAMESPACE__);

            return $type::create($args);
        }

    }
}