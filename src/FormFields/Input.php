<?php

namespace Backalley\FormFields;

use Backalley\Html\TagSage;
use Backalley\GuctilityBelt;


class Input extends AbstractField implements FormFieldInterface
{
    /**
     * @var string
     */
    public $type = 'text';

    /**
     * @var string
     */
    public $name;

    /**
     * @var mixed
     */
    public $value;

    /**
     *
     */
    public function __construct()
    {
        // code here
    }

    /**
     * Get the value of type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @param string  $type
     *
     * @return self
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string  $name
     *
     * @return self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @param mixed  $value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     *
     */
    public function __toString()
    {
        $this->attributes['value'] = $this->value;
        $this->attributes['type'] = $this->type;
        $this->attributes['name'] = $this->name;
        $this->attributes['id'] = $this->id;

        return $this->open('input', $this->attributes);
    }

    /**
     *
     */
    public function parse_args($args)
    {
        $this->type = $args['type'] ?? $this->attributes['type'] ?? $this->type;
        $this->name = $args['name'] ?? $this->attributes['name'] ?? $this->name;
        $this->value = $args['value'] ?? $this->attributes['value'] ?? $this->value;

        return $this;
    }

    // /**
    //  *
    //  */
    // public static function create($args): FormFieldInterface
    // {
    //     $type = $args['type'] ?? $args['attributes']['type'] ?? 'text';

    //     if (TagSage::is_it('standard_input_type', $type)) {
    //         return new static($args);
    //     } else {
    //         $type = GuctilityBelt::arg_to_class($type, '%s', __NAMESPACE__);

    //         return $type::create($args);
    //     }
    // }
}
