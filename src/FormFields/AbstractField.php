<?php

namespace Backalley\FormFields;

use Backalley\Html\HtmlConstructor;


abstract class AbstractField extends HtmlConstructor implements FormFieldInterface
{
    /**
     * @var array
     */
    public $attributes = [];

    /**
     *
     */
    final public function __construct($args = null, $charset = null)
    {
        parent::__construct($args, $charset);

        $this->set_attributes($args['attributes'] ?? null);
        $this->parse_args($args);
    }

    /**
     * set_attributes
     *
     * @param array $attributes
     * @return self
     */
    public function set_attributes(? array $attributes)
    {
        $this->attributes = $attributes ?? $this->attributes;

        return $this;
    }

    /**
     * get_attributes
     *
     * @param string
     * @return mixed
     */
    public function get_attributes()
    {
        return $this->attributes;
    }

    /**
     * create
     *
     * @param array $args
     * @return FormFieldInterface
     */
    public static function create($args) : FormFieldInterface
    {
        return new static($args);
    }

    /**
     * 
     */
    abstract protected function parse_args($args);

    /**
     * 
     */
    abstract public function __toString();
}