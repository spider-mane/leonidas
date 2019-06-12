<?php

namespace Backalley\WordPress\AdminPage;

use Backalley\Html\Html;
use Backalley\WordPress\ApiBase;
use Backalley\Wordpress\AdminSetting;

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
     * callable
     * 
     * @var callable
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
     * settings
     * 
     * @var array
     */
    public $settings;

    /**
     * 
     */
    public function __construct($args)
    {
        parent::__construct($args);

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
     * @param callable  $callback
     *
     * @return self
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
     * Get settings
     *
     * @return  array
     */
    public function get_settings()
    {
        return $this->settings;
    }

    /**
     * Set settings
     *
     * @param   array  $settings 
     *
     * @return  self
     */
    public function set_settings(array $settings)
    {
        foreach ($settings as $key => $setting) {
            $this->push_setting($setting);
        }

        return $this;
    }

    /**
     * 
     */
    public function push_setting($setting)
    {
        $setting = new AdminSetting($setting);
        $setting->section = $this->id;
        $setting->page = $this->page;

        $this->settings[] = $setting;

        return $this;
    }

    /**
     * 
     */
    public function add_settings_section()
    {
        add_settings_section($this->id, $this->title, [$this, 'render'], $this->page);
    }

    /**
     * 
     */
    public function render()
    {
        if (!isset($this->callback)) {
            $this->render_default();

        } else {
            $callback = $this->callback;
            $callback($this);
        }
    }

    /**
     * 
     */
    public function render_default()
    {
        echo Html::open('p') . $this->description . Html::close('p');
    }
}