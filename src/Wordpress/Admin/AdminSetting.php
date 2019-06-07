<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\Wordpress\Admin;

class AdminSetting
{
    /**
     * option_group
     * 
     * @var thing
     */
    public $option_group;

    /**
     * option_name
     * 
     * @var thing
     */
    public $option_name;

    /**
     * type
     * 
     * @var thing
     */
    public $type;

    /**
     * description
     * 
     * @var thing
     */
    public $description;

    /**
     * sanitize_callback
     * 
     * @var string
     */
    public $sanitize_callback;

    /**
     * show_in_rest
     * 
     * @var thing
     */
    public $show_in_rest;

    /**
     * default
     * 
     * @var thing
     */
    public $default;

    /**
     * field
     * 
     * @var thing
     */
    public $field;

    /**
     * tab
     * 
     * @var thing
     */
    public $tab;

    /**
     * 
     */
    public function register_setting()
    {
        $args = [
            $this->type,
            $this->description,
            $this->sanitize_callback,
            $this->show_in_rest,
            $this->default,
        ];

        register_setting($this->option_group, $this->option_name, $args);
    }

    /**
     * 
     */
    public function unregister_setting()
    {
        //
    }

    /**
     * Get sanitize_callback
     *
     * @return  string
     */
    public function get_sanitize_callback()
    {
        return $this->sanitize_callback;
    }

    /**
     * Set sanitize_callback
     *
     * @param   string  $sanitize_callback  sanitize_callback
     *
     * @return  self
     */
    public function set_sanitize_callback(string $sanitize_callback = null)
    {
        $this->sanitize_callback = $sanitize_callback ?? [$this, 'save_setting'];

        return $this;
    }

    /**
     * 
     */
    public function save_setting($value)
    {
        return $this->field->save($value);
    }
}
