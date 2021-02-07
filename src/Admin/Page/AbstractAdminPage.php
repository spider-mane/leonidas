<?php

namespace WebTheory\Leonidas\Admin\Page;

use WebTheory\Leonidas\Admin\Contracts\TemplateLoaderInterface;
use WebTheory\Leonidas\Admin\Traits\UsesTemplateTrait;

/**
 * @package Leonidas-Core
 */
abstract class AbstractAdminPage
{
    use UsesTemplateTrait;

    /**
     * @var string
     */
    protected $pageTitle = '';

    /**
     * @var string
     */
    protected $menuTitle = '';

    /**
     * @var string
     */
    protected $menuSlug;

    /**
     * @var string
     */
    protected $capability = 'manage_options';

    /**
     * @var callable
     */
    protected $function;

    /**
     * @var string
     */
    protected $icon;

    /**
     * @var int
     */
    protected $position;

    /**
     * @var string
     */
    protected $parentSlug;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $showInMenu = true;

    /**
     * The name that will be shown if the page has submenu items
     *
     * @var string
     */
    protected $subMenuName;

    /**
     * @see https://developer.wordpress.org/reference/hooks/admin_title/
     *
     * @var callable
     */
    protected $adminTitleCallback;

    /**
     * @see https://developer.wordpress.org/reference/hooks/submenu_file/
     *
     * @var callable
     */
    protected $submenuFileCallback;

    /**
     * @see https://developer.wordpress.org/reference/hooks/parent_file/
     *
     * @var callable
     */
    protected $parentFileCallback;

    /**
     * @var callable
     */
    protected $layout;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var TemplateLoaderInterface
     */
    protected $templateLoader;

    /**
     *
     */
    public function __construct(string $menuSlug, ?string $capability = null)
    {
        $this->menuSlug = $menuSlug;

        $capability && $this->capability = $capability;
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
     * Get menu_slug
     *
     * @return  string
     */
    public function getMenuSlug()
    {
        return $this->menuSlug;
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
    public function setMenuTitle(string $menuTitle)
    {
        $this->menuTitle = $menuTitle;

        return $this;
    }

    /**
     * Get function
     *
     * @return callable
     */
    public function getFunction(): callable
    {
        return $this->function;
    }

    /**
     * Set function
     *
     * @param callable $function  function
     *
     * @return  self
     */
    public function setFunction(callable $function)
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
    public function SetParentSlug(string $parentSlug)
    {
        $this->parentSlug = $parentSlug;

        return $this;
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
     * @param string $subMenuName
     *
     * @return self
     */
    public function setSubMenuName(string $subMenuName)
    {
        $this->subMenuName = $subMenuName;

        return $this;
    }

    /**
     * Get the value of adminTitleCallback
     *
     * @return callable
     */
    public function getAdminTitleCallback(): callable
    {
        return $this->adminTitleCallback;
    }

    /**
     * Set the value of adminTitleCallback
     *
     * @param callable $adminTitleCallback
     *
     * @return self
     */
    public function setAdminTitleCallback(callable $adminTitleCallback)
    {
        $this->adminTitleCallback = $adminTitleCallback;

        return $this;
    }

    /**
     * Get the value of submenuFileCallback
     *
     * @return callable
     */
    public function getSubmenuFileCallback(): callable
    {
        return $this->submenuFileCallback;
    }

    /**
     * Set the value of submenuFileCallback
     *
     * @param callable $submenuFileCallback
     *
     * @return self
     */
    public function setSubmenuFileCallback(callable $submenuFileCallback)
    {
        $this->submenuFileCallback = $submenuFileCallback;

        return $this;
    }

    /**
     * Get the value of parentFileCallback
     *
     * @return callable
     */
    public function getParentFileCallback(): callable
    {
        return $this->parentFileCallback;
    }

    /**
     * Set the value of parentFileCallback
     *
     * @param callable $parentFileCallback
     *
     * @return self
     */
    public function setParentFileCallback(callable $parentFileCallback)
    {
        $this->parentFileCallback = $parentFileCallback;

        return $this;
    }

    /**
     * Get the value of layout
     *
     * @return callable
     */
    public function getLayout(): callable
    {
        return $this->layout;
    }

    /**
     * Set the value of layout
     *
     * @param callable $layout
     *
     * @return self
     */
    public function setLayout(callable $layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get the value of alertLoader
     *
     * @return callable
     */
    public function getAlertLoader(): callable
    {
        return $this->alertLoader;
    }

    /**
     * Set the value of alertLoader
     *
     * @param callable $alertLoader
     *
     * @return self
     */
    public function setAlertLoader(callable $alertLoader)
    {
        $this->alertLoader = $alertLoader;

        return $this;
    }

    /**
     * Get the value of templateLoader
     *
     * @return TemplateLoaderInterface
     */
    public function getTemplateLoader(): TemplateLoaderInterface
    {
        return $this->templateLoader;
    }

    /**
     * Set the value of templateLoader
     *
     * @param TemplateLoaderInterface $templateLoader
     *
     * @return self
     */
    public function setTemplateLoader(TemplateLoaderInterface $templateLoader)
    {
        $this->templateLoader = $templateLoader;

        return $this;
    }

    /**
     *
     */
    public function hook()
    {
        add_action('admin_menu', [$this, 'register']);

        return $this;
    }

    /**
     *
     */
    public function register()
    {
        if (isset($this->parentSlug)) {
            $this->addSubmenuPage()->configurePage('submenu');
        } else {
            $this->addMenuPage()->configurePage('menu');
        }

        return $this;
    }

    /**
     *
     */
    final protected function addSubmenuPage()
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
    final protected function addMenuPage()
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
    protected function configurePage(string $level)
    {
        if (false === $this->showInMenu) {
            ([$this, "remove{$level}page"])();
        }

        if (isset($this->adminTitleCallback)) {
            add_filter('admin_title', $this->adminTitleCallback, PHP_INT_MAX, PHP_INT_MAX);
        }

        ([$this, "configure{$level}page"])();

        return $this;
    }

    /**
     *
     */
    protected function configureMenuPage()
    {
        return $this;
    }

    /**
     *
     */
    protected function configureSubmenuPage()
    {
        if (isset($this->submenuFileCallback)) {
            add_filter('submenu_file', $this->submenuFileCallback, null, PHP_INT_MAX);
        }

        if (isset($this->parentFileCallback)) {
            add_filter('parent_file', $this->parentFileCallback, null, PHP_INT_MAX);
        }

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
    public function doAdminNotices()
    {
        do_action('admin_notices');
    }

    /**
     *
     */
    public function render($args)
    {
        !isset($this->function) ? $this->renderDefault() : ($this->function)($args, $this);
    }

    /**
     *
     */
    protected function getTemplateContext(): array
    {
        return [
            'title' => $this->pageTitle,
            'page' => $this->menuSlug,
            'layout' => $this->layout,
            'alerts' => $this->alertLoader ?? [$this, 'doAdminNotices'],
            'description' => $this->description,
        ];
    }

    /**
     *
     */
    protected function renderDefault()
    {
        $context = $this->getTemplateContext();

        $layout = isset($this->templateLoader)
            ? $this->templateLoader->renderTemplate($context)
            : $this->renderTemplate($context);

        echo $layout;
    }
}
