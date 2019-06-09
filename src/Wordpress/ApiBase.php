<?php

namespace Backalley\WordPress;

abstract class ApiBase
{
    /**
     * default constructor
     */
    public function __construct($args)
    {
        foreach ($args as $property => $value) {
            $setter = "set_{$property}";

            if (method_exists($this, $setter)) {
                $this->$setter($value);

            } elseif (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }
}