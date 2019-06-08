<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\Wordpress;

use Timber\Timber;
use Backalley\Backalley;


class AdminPage extends ApiBase
{
    /**
     * settings
     * 
     * @var array
     */
    public $page_title = '';

    /**
     * settings
     * 
     * @var array
     */
    public $menu_title = '';

    /**
     * settings
     * 
     * @var array
     */
    public $capability;

    /**
     * settings
     * 
     * @var array
     */
    public $menu_slug;

    /**
     * settings
     * 
     * @var array
     */
    public $function;

    /**
     * settings
     * 
     * @var array
     */
    public $icon;

    /**
     * settings
     * 
     * @var array
     */
    public $position;

    /**
     * settings
     * 
     * @var array
     */
    public $parent_slug;

    /**
     * show in menu
     * 
     * @var bool
     */
    public $show_in_menu = true;

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
     * settings
     * 
     * @var array
     */
    public $tabs = [];

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

        $this->set_dynamic_defaults();

        add_action('admin_menu', [$this, 'add_page']);
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
     * @return  array
     */
    public function get_page_title()
    {
        return $this->page_title;
    }

    /**
     * Set settings
     *
     * @param   array  $page_title  settings
     *
     * @return  self
     */
    public function set_page_title(string $page_title)
    {
        $this->page_title = $page_title;

        return $this;
    }

    /**
     * Get settings
     *
     * @return  array
     */
    public function get_menu_title()
    {
        return $this->menu_title;
    }

    /**
     * Set settings
     *
     * @param   array  $menu_title  settings
     *
     * @return  self
     */
    public function set_menu_title(string $menu_title)
    {
        $this->menu_title = $menu_title;

        return $this;
    }

    /**
     * Get settings
     *
     * @return  array
     */
    public function get_capability()
    {
        return $this->capability;
    }

    /**
     * Set settings
     *
     * @param   array  $capability  settings
     *
     * @return  self
     */
    public function set_capability(string $capability)
    {
        $this->capability = $capability;

        return $this;
    }

    /**
     * Get settings
     *
     * @return  array
     */
    public function get_menu_slug()
    {
        return $this->menu_slug;
    }

    /**
     * Set settings
     *
     * @param   array  $menu_slug  settings
     *
     * @return  self
     */
    public function set_menu_slug(string $menu_slug)
    {
        $this->menu_slug = $menu_slug;

        return $this;
    }

    /**
     * Get settings
     *
     * @return  array
     */
    public function get_function()
    {
        return $this->function;
    }

    /**
     * Set settings
     *
     * @param   array  $function  settings
     *
     * @return  self
     */
    public function set_function($function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get settings
     *
     * @return  array
     */
    public function get_position()
    {
        return $this->position;
    }

    /**
     * Set settings
     *
     * @param   array  $position  settings
     *
     * @return  self
     */
    public function set_position(int $position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get settings
     *
     * @return  array
     */
    public function get_parent_slug()
    {
        return $this->parent_slug;
    }

    /**
     * Set settings
     *
     * @param   array  $parent_slug  settings
     *
     * @return  self
     */
    public function set_parent_slug(string $parent_slug)
    {
        $this->parent_slug = $parent_slug;

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
     * @param   array  $sections  sections
     *
     * @return  self
     */
    public function set_sections(array $sections)
    {
        foreach ($sections as $section) {
            $this->sections[] = new SettingsSection($section);
        }

        return $this;
    }

    /**
     * Get settings
     *
     * @return  array
     */
    public function get_tabs()
    {
        return $this->tabs;
    }

    /**
     * Set settings
     *
     * @param   array  $tabs  settings
     *
     * @return  self
     */
    public function set_tabs(array $tabs)
    {
        $this->tabs = $tabs;

        return $this;
    }

    /**
     * 
     */
    public function add_page()
    {
        if (isset($this->parent_slug)) {
            $this->add_submenu_page()->fix_page_assets('submenu_page');
        } else {
            $this->add_menu_page()->fix_page_assets('menu_page');
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
            $this->function
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
            $this->function,
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
    protected function fix_page_assets($menu_context)
    {
        if (false === $this->show_in_menu) {
            $remove_page = "remove_{$menu_context}";
            $this->$remove_page();
        }
    }

    /**
     * 
     */
    public function render()
    {
        $templateData = [
            'title' => $this->page_title,
            'tabs' => $this->tabs,
            'sections' => $this->sections,
            'fields' => $this->fields,
        ];

        Timber::render('admin-page__default-template.twig', $templateData);
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
}