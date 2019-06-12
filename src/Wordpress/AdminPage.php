<?php

namespace Backalley\WordPress;

use Timber\Timber;
use Backalley\WordPress\AdminPage\SettingsSection;


/**
 * @package Backalley-Core
 */
class AdminPage extends ApiBase
{
    /**
     * page_title
     * 
     * @var string
     */
    public $page_title = '';

    /**
     * menu_title
     * 
     * @var string
     */
    public $menu_title = '';

    /**
     * menu_slug
     * 
     * @var string
     */
    public $menu_slug;

    /**
     * capability
     * 
     * @var string
     */
    public $capability;

    /**
     * function
     * 
     * @var callback
     */
    public $function;

    /**
     * icon
     * 
     * @var string
     */
    public $icon;

    /**
     * position
     * 
     * @var int
     */
    public $position;

    /**
     * parent_slug
     * 
     * @var string
     */
    public $parent_slug;

    /**
     * description
     * 
     * @var string
     */
    public $description;

    /**
     * show_in_menu
     * 
     * @var bool
     */
    public $show_in_menu = true;

    /**
     * layout
     * 
     * @var string
     */
    public $layout = 'wp_basic';

    /**
     * tabs
     * 
     * @var array
     */
    public $tabs = [];

    /**
     * settings
     * 
     * @var array
     */
    public $settings = [];

    /**
     * sections
     * 
     * @var array
     */
    public $sections = [];

    /**
     * field_groups
     * 
     * @var array
     */
    public $field_groups = [];

    /**
     * 
     */
    public function __construct($args)
    {
        parent::__construct($args);

        // $this->set_dynamic_defaults();

        add_action('admin_menu', [$this, 'add_page']);
    }

    /**
     * 
     */
    public static function create($pages)
    {
        foreach ($pages as $index => $args) {
            $pages[$index] = new static($args);
        }

        return $pages;
    }

    /**
     * 
     */
    private function set_dynamic_defaults()
    {
        $defaults = [
            'function' => [$this, 'render']
        ];

        foreach ($defaults as $property => $value) {
            if (is_null($this->$property)) {
                $this->$property = $value;
            }
        }

        return $this;
    }

    /**
     * Get settings
     *
     * @return  string
     */
    public function get_page_title()
    {
        return $this->page_title;
    }

    /**
     * Set settings
     *
     * @param   string  $page_title  settings
     *
     * @return  self
     */
    public function set_page_title(string $page_title)
    {
        $this->page_title = $page_title;

        return $this;
    }

    /**
     * Get menu_title
     *
     * @return  string
     */
    public function get_menu_title()
    {
        return $this->menu_title;
    }

    /**
     * Set settings
     *
     * @param   string  $menu_title  settings
     *
     * @return  self
     */
    public function set_menu_title(string $menu_title)
    {
        $this->menu_title = $menu_title;

        return $this;
    }

    /**
     * Get capability
     *
     * @return  array
     */
    public function get_capability()
    {
        return $this->capability;
    }

    /**
     * Set capability
     *
     * @param   array  $capability  capability
     *
     * @return  self
     */
    public function set_capability(string $capability)
    {
        $this->capability = $capability;

        return $this;
    }

    /**
     * Get menu_slug
     *
     * @return  string
     */
    public function get_menu_slug()
    {
        return $this->menu_slug;
    }

    /**
     * Set menu_slug
     *
     * @param   string  $menu_slug  menu_slug
     *
     * @return  self
     */
    public function set_menu_slug(string $menu_slug)
    {
        $this->menu_slug = $menu_slug;

        return $this;
    }

    /**
     * Get function
     *
     * @return  array
     */
    public function get_function()
    {
        return $this->function;
    }

    /**
     * Set function
     *
     * @param   callback  $function  function
     *
     * @return  self
     */
    public function set_function(callback $function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get position
     *
     * @return int
     */
    public function get_position()
    {
        return $this->position;
    }

    /**
     * Set position
     *
     * @param int  $position  position
     *
     * @return  self
     */
    public function set_position(int $position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get parent_slug
     *
     * @return  string
     */
    public function get_parent_slug()
    {
        return $this->parent_slug;
    }

    /**
     * Set parent_slug
     *
     * @param   string  $parent_slug  parent_slug
     *
     * @return  self
     */
    public function set_parent_slug(string $parent_slug)
    {
        $this->parent_slug = $parent_slug;

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
     * @param   array  $settings  settings
     *
     * @return  self
     */
    public function set_settings(array $settings)
    {
        foreach ($settings as $index => $setting) {
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
        $setting->set_page($this->menu_slug);

        $this->settings[] = $setting;

        return $this;
    }

    /**
     * Get sections
     *
     * @return  array
     */
    public function get_sections()
    {
        return $this->sections;
    }

    /**
     * Set sections
     *
     * @param   array  $sections
     *
     * @return  self
     */
    public function set_sections(array $sections)
    {
        foreach ($sections as $section) {
            $this->push_section($section);
        }

        return $this;
    }

    /**
     * 
     */
    public function push_section($section, $key = null)
    {
        $section = new SettingsSection(['page' => $this->menu_slug] + $section);

        $this->sections[] = $section;

        return $this;
    }

    /**
     * Get tabs
     *
     * @return  array
     */
    public function get_tabs()
    {
        return $this->tabs;
    }

    /**
     * Set tabs
     *
     * @param   array  $tabs
     *
     * @return  self
     */
    public function set_tabs(array $tabs)
    {
        $this->tabs = $tabs;

        return $this;
    }

    /**
     * Get field_groups
     *
     * @return  array
     */
    public function get_field_groups()
    {
        return $this->field_groups;
    }

    /**
     * Set field_groups
     *
     * @param   mixed  $field_groups  fields
     *
     * @return  self
     */
    public function set_field_groups($field_groups)
    {
        foreach (is_array($field_groups) ? $field_groups : [$field_groups] as $field) {
            $this->add_field_group($field);
        }

        return $this;
    }

    /**
     * 
     */
    public function add_field_group($field_group)
    {
        $this->field_groups[] = $field_group;

        return $this;
    }

    /**
     * 
     */
    public function add_page()
    {
        if (isset($this->parent_slug)) {
            $this->add_submenu_page()->fix_page_assets('submenu');
        } else {
            $this->add_menu_page()->fix_page_assets('menu');
        }

        return $this;
    }

    /**
     * 
     */
    protected function add_submenu_page()
    {
        add_submenu_page(
            $this->parent_slug,
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->menu_slug,
            [$this, 'render']
        );

        return $this;
    }

    /**
     * 
     */
    protected function add_menu_page()
    {
        add_menu_page(
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->menu_slug,
            [$this, 'render'],
            $this->icon,
            $this->position
        );

        return $this;
    }

    /**
     * 
     */
    protected function remove_menu_page()
    {
        remove_menu_page($this->menu_slug);

        return $this;
    }

    /**
     * 
     */
    protected function remove_submenu_page()
    {
        remove_submenu_page($this->parent_slug, $this->menu_slug);

        return $this;
    }

    /**
     * 
     */
    protected function fix_page_assets($level)
    {
        if (false === $this->show_in_menu) {
            $remove_page = "remove_{$level}_page";
            $this->$remove_page();
        }
    }

    /**
     * 
     */
    public function render($args)
    {
        if (!isset($this->function)) {
            $this->render_default($this);

        } else {
            $callback = $this->function;
            $callback($this, $args);
        }
    }

    /**
     * 
     */
    public function render_default()
    {
        $templateData = [
            'title' => $this->page_title,
            'tabs' => $this->tabs,
            'page' => $this->menu_slug,
            'layout' => $this->layout,
            'description' => $this->description,
            'field_groups' => $this->field_groups,
        ];

        Timber::render('admin-page-template.twig', $templateData);
    }

    /**
     * 
     */
    public static function layout($layout)
    {
        $data = [];
        $layout = "{$layout}.twig";

        Timber::render($layout, $data);
    }
}