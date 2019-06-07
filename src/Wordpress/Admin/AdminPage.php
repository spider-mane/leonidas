<?php

/**
 * @package Backalley-Core
 */

namespace Backalley\Wordpress\Admin;


class AdminPage
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
    public $capablility;

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
    public $callback;

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

    /**
     *
     */
    public function render()
    {
        // code here
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
    public function set_page_title(array $page_title)
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
    public function set_menu_title(array $menu_title)
    {
        $this->menu_title = $menu_title;

        return $this;
    }

    /**
     * Get settings
     *
     * @return  array
     */
    public function get_capablility()
    {
        return $this->capablility;
    }

    /**
     * Set settings
     *
     * @param   array  $capablility  settings
     *
     * @return  self
     */
    public function set_capablility(array $capablility)
    {
        $this->capablility = $capablility;

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
    public function set_menu_slug(array $menu_slug)
    {
        $this->menu_slug = $menu_slug;

        return $this;
    }

    /**
     * Get settings
     *
     * @return  array
     */
    public function get_callback()
    {
        return $this->callback;
    }

    /**
     * Set settings
     *
     * @param   array  $callback  settings
     *
     * @return  self
     */
    public function set_callback(array $callback)
    {
        $this->callback = $callback;

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
    public function set_position(array $position)
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
    public function set_parent_slug(array $parent_slug)
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
        $this->sections = $sections;

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
}