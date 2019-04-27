<?php

/**
 * @package Backalley
 */


// namespace Backalley\Api;

final class Backalley_Admin_Settings
{
    public $admin_pages = [];

    public $admin_subpages = [];

    public $settings = [];

    public $sections = [];

    public $fields = [];

    public function __construct()
    {
        parent::__construct();

        $methods = [
            'set_admin_pages',
            'set_admin_subpages',
            'set_settings',
            'set_settings_sections',
            'set_settings_fields'
        ];

        foreach ($methods as $method) {
            if (method_exists($this, $method)) {
                $this->{$method}();
            }
        }


        if (!empty($this->admin_pages) || !empty($this->admin_subpages)) {
            add_action('admin_menu', [$this, 'add_admin_menu']);
        }

        if (!empty($this->settings)) {
            add_action('admin_init', [$this, 'register_settings_an_dem']);
        }
    }

    #AdminMethods

    #AdminMenu
    public function add_admin_menu()
    {
        foreach ($this->admin_pages as $page => $attr) {
            $expected_args = [
                'page_title',
                'menu_title',
                'capability',
                'menu_slug',
                'callback',
                'icon_url',
                'position',

                /*
                 * below are attributes not needed by add_menu_page(),
                 * but other related feaures of WordPress handled here
                 */
                'parent_filter',
                'subpage_name'
            ];
            foreach ($expected_args as $arg) {
                ${$arg} = isset($attr[$arg]) ? $attr[$arg] : null;
            }

            add_menu_page($page_title, $menu_title, $capability, $menu_slug, $callback, $icon_url, $position);

            if (!empty($subpage_name)) {
                $this->admin_page_as_subpage($page, $subpage_name);
            }

            if (empty($callback) && is_callable($parent_filter)) {
                $parent_slug = add_filter('parent_file', $parent_filter);
            }
        }


        #AddSubpages
        foreach ($this->admin_subpages as $page) {
            $expected_args = [
                'parent_slug',
                'page_title',
                'menu_title',
                'capability',
                'menu_slug',
                'callback',

                /*
                 * below are attributes not needed by add_submenu_page(),
                 * but other related feaures of WordPress handled here
                 */
                'parent_filter',
                'subpage_filter'
            ];
            foreach ($expected_args as $arg) {
                ${$arg} = isset($page[$arg]) ? $page[$arg] : null;
            }

            add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $callback);

            if (empty($callback) && is_callable($parent_filter)) {
                $parent_slug = add_filter('parent_file', $parent_filter);
            }
        }
    }

    #PageAsSubpage
    protected function admin_page_as_subpage(string $slug, string $title = null)
    {
        $admin_page = $this->admin_pages[$slug];

        $subpage = [
            'parent_slug' => isset($admin_page['menu_slug']) ? $admin_page['menu_slug'] : null,
            'page_title' => isset($admin_page['page_title']) ? $admin_page['page_title'] : null,
            'menu_title' => $title ?: (isset($admin_page['menu_title']) ? $admin_page['menu_title'] : null),
            'capability' => isset($admin_page['capability']) ? $admin_page['capability'] : null,
            'menu_slug' => isset($admin_page['menu_slug']) ? $admin_page['menu_slug'] : null,
            'callback' => isset($admin_page['callback']) ? $admin_page['callback'] : null,
        ];

        array_unshift($this->admin_subpages, $subpage);
    }

    #RegisterSettings

    /**
     * Registers settings and them
     * Them is sections and fields whose purpose is complementary to settings
     * @return null
     */
    public function register_settings_an_dem()
    {
        // register setting
        foreach ($this->settings as $setting) {
            if (false === get_option($setting['option_name'])) {
                add_option($setting['option_name']);
            }
            // if (false === get_option($setting['option_name'])) echo 'some shit';

            register_setting($setting['option_group'], $setting['option_name'], (isset($setting['args']) ? $setting['args'] : ''));

            // var_dump(!get_option($setting['option_name']));
        }

        // add settings section
        foreach ($this->sections as $section) {
            add_settings_section($section['id'], $section['title'], (isset($section['callback']) ? $section['callback'] : ''), $section['page']);
        }

        // add settings field
        foreach ($this->fields as $field) {
            add_settings_field($field['id'], $field['title'], (isset($field['callback']) ? $field['callback'] : ''), $field['page'], $field['section'], (isset($field['args']) ? $field['args'] : ''));
        }
    }

    /**
     *
     */
    public function set_admin_pages()
    {
        // code here
    }

    public function set_admin_subpages()
    {
        // code here
    }

    /**
     *
     */
    protected function set_settings()
    {
        // code here
    }

    /**
     *
     */
    public function set_settings_sections()
    {
        // code here
    }

    /**
     *
     */
    public function set_settings_fields()
    {
        // code here
    }

    /**
     *
     */
    public function admin_settings_input_handler()
    {
        // code here
    }

    /**
     *
     */
    public function admin_page_loader()
    {
        // code here
    }
}
