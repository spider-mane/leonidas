<?php

namespace Backalley\WordPress;

/**
 * 
 */
class AdminUiSet extends ApiBase
{
    /**
     * pages
     * 
     * @var array
     */
    public $pages;

    /**
     * sections
     * 
     * @var array
     */
    public $sections;

    /**
     * settings
     * 
     * @var array
     */
    public $settings;

    /**
     * Get pages
     *
     * @return  array
     */
    public function get_pages()
    {
        return $this->pages;
    }

    /**
     * Set pages
     *
     * @param   array  $pages  pages
     *
     * @return  self
     */
    public function set_pages(array $pages)
    {
        $this->pages = AdminPage::create($pages);

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
        $this->sections = SettingsSection::create($sections);

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
        $this->settings = AdminSetting::create($settings);

        return $this;
    }

    /**
     * 
     */
    public static function create($features)
    {
        return new static($features);
    }
}
