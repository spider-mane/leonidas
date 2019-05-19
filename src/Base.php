<?php

namespace Backalley;

class Base
{
    /**
     * 
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $property;
        }
    }

    /**
     * 
     */
    public function __set($property, $value = null)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value ?? $this->property;
        }
    }
}