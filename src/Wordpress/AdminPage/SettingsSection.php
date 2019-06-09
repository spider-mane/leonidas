<?php

namespace Backalley\WordPress\AdminPage;

use Backalley\WordPress\ApiBase;
use Backalley\Wordpress\Admin\AdminSetting;

/**
 * 
 */
class SettingsSection extends ApiBase
{
    /**
     * id
     * 
     * @var string
     */
    public $id;

    /**
     * title
     * 
     * @var string
     */
    public $title;

    /**
     * callback
     * 
     * @var callback
     */
    public $callback;

    /**
     * page
     * 
     * @var string
     */
    public $page;

    /**
     * description
     * 
     * @var string
     */
    public $description;

    /**
     * fields
     * 
     * @var string
     */
    public $settings;

    /**
     * 
     */
    public function __construct($args)
    {
        parent::__construct($args);

        if (!isset($this->callback)) {
            $this->set_callback([$this, 'render']);
        }

        add_action('admin_init', [$this, 'add_settings_section']);
    }

    /**
     * 
     */
    public static function create($sections)
    {
        foreach ($sections as $index => $args) {
            $sections[$index] = new static($args);
        }

        return $sections;
    }

    /**
     * Get id
     *
     * @return  string
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param   string  $id  id
     *
     * @return  self
     */
    public function set_id(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get title
     *
     * @return  string
     */
    public function get_title()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param   string  $title  title
     *
     * @return  self
     */
    public function set_title(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get callback
     *
     * @return  string
     */
    public function get_callback()
    {
        return $this->callback;
    }

    /**
     * Set callback
     *
     * @param   callback  $callback  callback
     *
     * @return  self
     */
    public function set_callback(callable $callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * Get page
     *
     * @return  string
     */
    public function get_page()
    {
        return $this->page;
    }

    /**
     * Set page
     *
     * @param   string  $page  page
     *
     * @return  self
     */
    public function set_page(string $page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get description
     *
     * @return  string
     */
    public function get_description()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param   string  $description  description
     *
     * @return  self
     */
    public function set_description(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get fields
     *
     * @return  string
     */
    public function get_settings()
    {
        return $this->settings;
    }

    /**
     * Set fields
     *
     * @param   string  $settings  fields
     *
     * @return  self
     */
    public function set_settings(string $settings)
    {
        foreach ($settings as $key => $setting) {
            $this->push_setting($setting);
        }
        $this->settings = $settings;

        return $this;
    }

    /**
     * 
     */
    public function push_setting($setting)
    {
        $setting = new AdminSetting($setting);
        $setting->section = $this->id;

        $this->settings[] = $setting;

        return $this;
    }

    /**
     * 
     */
    public function add_settings_section()
    {
        add_settings_section($this->id, $this->title, $this->callback, $this->page);
    }

    /**
     * 
     */
    public function render()
    {
        echo $this->description;
    }
}