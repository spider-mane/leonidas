<?php

namespace Backalley\WordPress;

/**
 * 
 */
class Option extends ApiBase
{
    /**
     * name
     * 
     * @var string
     */
    public $name;

    /**
     * value
     * 
     * @var mixed
     */
    public $value;

    /**
     * autoload
     * 
     * @var bool
     */
    public $autoload = true;

    /**
     * 
     */
    public function __construct($name, $value, $autoload)
    {
        parent::__construct([
            'name' => $name,
            'value' => $value,
            'autoload' => $autoload,
        ]);

        $this->add_option();
    }

    /**
     * Get name
     *
     * @return  string
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param   string  $name  name
     *
     * @return  self
     */
    public function set_name(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get value
     *
     * @return  mixed
     */
    public function get_value()
    {
        return $this->value;
    }

    /**
     * Set value
     *
     * @param   mixed  $value  value
     *
     * @return  self
     */
    public function set_value($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get autoload
     *
     * @return  bool
     */
    public function get_autoload()
    {
        return $this->autoload;
    }

    /**
     * Set autoload
     *
     * @param   bool  $autoload  autoload
     *
     * @return  self
     */
    public function set_autoload(bool $autoload)
    {
        $this->autoload = $autoload;

        return $this;
    }

    /**
     * 
     */
    public function get_option()
    {
        return get_option($this->name, $this->value);
    }

    /**
     * 
     */
    public function add_option()
    {
        add_option($this->name, $this->value, null, $this->autoload);
    }
}