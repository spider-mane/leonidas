<?php

namespace Backalley\FormFields;

/**
 * 
 */
trait SingleValueTrait
{
    /**
     * Get the value of name
     *
     * @return  string
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param   string  $name  
     *
     * @return  self
     */
    public function set_name(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of value
     *
     * @return  string
     */
    public function get_value()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @param   string  $value  
     *
     * @return  self
     */
    public function set_value(string $value)
    {
        $this->value = $value;

        return $this;
    }
}