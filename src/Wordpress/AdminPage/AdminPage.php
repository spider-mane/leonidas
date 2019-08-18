<?php

namespace Backalley\Wordpress\AdminPage;

use Backalley\WordPress\AdminPage\SettingsSection;
use Backalley\Wordpress\MetaBox\Traits\UsesTemplateTrait;

/**
 * @package Backalley-Core
 */
class AdminPage
{
    use UsesTemplateTrait;

    /**
     * page_title
     *
     * @var string
     */
    protected $pageTitle = '';

    /**
     * menu_title
     *
     * @var string
     */
    protected $menuTitle = '';

    /**
     * menu_slug
     *
     * @var string
     */
    protected $menuSlug;

    /**
     * capability
     *
     * @var string
     */
    protected $capability = 'manage_options';

    /**
     * function
     *
     * @var callback
     */
    protected $function;

    /**
     * icon
     *
     * @var string
     */
    protected $icon;

    /**
     * position
     *
     * @var int
     */
    protected $position;

    /**
     * parent_slug
     *
     * @var string
     */
    protected $parentSlug;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * show_in_menu
     *
     * @var bool
     */
    protected $showInMenu = true;

    /**
     * The name that will be shown it the page has submenu items
     *
     * @var string
     */
    protected $subMenuName;

    /**
     * tabs
     *
     * @var array
     */
    protected $tabs = [];

    /**
     * settings
     *
     * @var array
     */
    protected $settings = [];

    /**
     * sections
     *
     * @var array
     */
    protected $sections = [];

    /**
     * field_groups
     *
     * @var array
     */
    protected $fieldGroups = [];

    /**
     *
     */
    private $layout;

    /**
     * @var string
     */
    private $template = 'admin-page-template';

    /**
     *
     */
    public function __construct(string $menu_slug, string $capability)
    {
        $this->setMenuSlug($menu_slug)->setCapability($capability);
    }

    /**
     *
     */
    public function hook()
    {
        add_action('admin_menu', [$this, 'addPage']);

        return $this;
    }

    /**
     * Get settings
     *
     * @return  string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * Set settings
     *
     * @param   string  $pageTitle  settings
     *
     * @return  self
     */
    public function setPageTitle(string $pageTitle)
    {
        $this->pageTitle = $pageTitle;

        return $this;
    }

    /**
     * Get menu_title
     *
     * @return  string
     */
    public function getMenuTitle()
    {
        return $this->menuTitle;
    }

    /**
     * Set settings
     *
     * @param   string  $menu_title  settings
     *
     * @return  self
     */
    public function setMenuTitle(string $menu_title)
    {
        $this->menuTitle = $menu_title;

        return $this;
    }

    /**
     * Get capability
     *
     * @return  array
     */
    public function getCapability()
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
    public function setCapability(string $capability)
    {
        $this->capability = $capability;

        return $this;
    }

    /**
     * Get menu_slug
     *
     * @return  string
     */
    public function getMenuSlug()
    {
        return $this->menuSlug;
    }

    /**
     * Set menu_slug
     *
     * @param   string  $menu_slug  menu_slug
     *
     * @return  self
     */
    public function setMenuSlug(string $menu_slug)
    {
        $this->menuSlug = $menu_slug;

        return $this;
    }

    /**
     * Get function
     *
     * @return  array
     */
    public function getFunction()
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
    public function setFunction(callback $function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition(): int
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
    public function setPosition(int $position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get parent_slug
     *
     * @return  string
     */
    public function getParentSlug()
    {
        return $this->parentSlug;
    }

    /**
     * Set parent_slug
     *
     * @param   string  $parent_slug  parent_slug
     *
     * @return  self
     */
    public function SetParentSlug(string $parent_slug)
    {
        $this->parentSlug = $parent_slug;

        return $this;
    }

    /**
     * Get settings
     *
     * @return  array
     */
    public function getSettings()
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
    public function setSettings(array $settings)
    {
        foreach ($settings as $setting) {
            $this->addSetting($setting);
        }

        return $this;
    }

    /**
     *
     */
    public function addSetting(AdminSetting $setting)
    {
        $this->settings[] = $setting->setPage($this->menuSlug);

        return $this;
    }

    /**
     * Get sections
     *
     * @return  array
     */
    public function getSections()
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
    public function setSections(array $sections)
    {
        foreach ($sections as $section) {
            $this->addSection($section);
        }

        return $this;
    }

    /**
     *
     */
    public function addSection(SettingsSection $section)
    {
        $this->sections[] = $section->setPage($this->menuSlug);

        return $this;
    }

    /**
     * Get tabs
     *
     * @return  array
     */
    public function getTabs()
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
    public function setTabs(array $tabs)
    {
        $this->tabs = $tabs;

        return $this;
    }

    /**
     * Get field_groups
     *
     * @return  array
     */
    public function getFieldGroups()
    {
        return $this->fieldGroups;
    }

    /**
     * Set field_groups
     *
     * @param   mixed  $field_groups  fields
     *
     * @return  self
     */
    public function setFieldGroups($field_groups)
    {
        foreach (is_array($field_groups) ? $field_groups : [$field_groups] as $field) {
            $this->addFieldGroup($field);
        }

        return $this;
    }

    /**
     *
     */
    public function addFieldGroup($field_group)
    {
        $this->fieldGroups[] = $field_group;

        return $this;
    }

    /**
     *
     */
    public function addPage()
    {
        if (isset($this->parentSlug)) {
            $this->addSubmenuPage()->removePage('submenu');
        } else {
            $this->addMenuPage()->removePage('menu');
        }

        return $this;
    }

    /**
     *
     */
    protected function addSubmenuPage()
    {
        add_submenu_page(
            $this->parentSlug,
            $this->pageTitle,
            $this->menuTitle,
            $this->capability,
            $this->menuSlug,
            [$this, 'render']
        );

        return $this;
    }

    /**
     *
     */
    protected function addMenuPage()
    {
        add_menu_page(
            $this->pageTitle,
            $this->menuTitle,
            $this->capability,
            $this->menuSlug,
            [$this, 'render'],
            $this->icon,
            $this->position
        );

        return $this;
    }

    /**
     *
     */
    protected function removeMenuPage()
    {
        remove_menu_page($this->menuSlug);

        return $this;
    }

    /**
     *
     */
    protected function removeSubmenuPage()
    {
        remove_submenu_page($this->parentSlug, $this->menuSlug);

        return $this;
    }

    /**
     *
     */
    protected function removePage($level)
    {
        if (false === $this->showInMenu) {
            $remove_page = "remove{$level}page";
            $this->$remove_page();
        }
    }

    /**
     *
     */
    public function render($args)
    {
        if (!isset($this->function)) {
            $this->renderDefault($this);
        } else {
            $callback = $this->function;
            $callback($this, $args);
        }
    }

    /**
     *
     */
    public function renderDefault()
    {
        $context = [
            'title' => $this->pageTitle,
            'tabs' => $this->tabs,
            'page' => $this->menuSlug,
            'layout' => $this->layout,
            'description' => $this->description,
            'field_groups' => $this->fieldGroups,
        ];

        echo $this->renderTemplate($context);
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * Set icon
     *
     * @param string $icon icon
     *
     * @return self
     */
    public function setIcon(string $icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get show_in_menu
     *
     * @return bool
     */
    public function isShownInMenu(): bool
    {
        return $this->showInMenu;
    }

    /**
     * Set show_in_menu
     *
     * @param bool $showInMenu show_in_menu
     *
     * @return self
     */
    public function setShowInMenu(bool $showInMenu)
    {
        $this->showInMenu = $showInMenu;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description description
     *
     * @return self
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the name that will be shown it the page has submenu items
     *
     * @return string
     */
    public function getSubMenuName(): string
    {
        return $this->subMenuName;
    }

    /**
     * Set the name that will be shown it the page has submenu items
     *
     * @param string $subMenuName The name that will be shown it the page has submenu items
     *
     * @return self
     */
    public function setSubMenuName(string $subMenuName)
    {
        $this->subMenuName = $subMenuName;

        return $this;
    }
}
