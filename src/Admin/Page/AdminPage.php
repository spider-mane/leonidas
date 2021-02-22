<?php

namespace WebTheory\Leonidas\Admin\Page;

use GuzzleHttp\Psr7\ServerRequest;
use WebTheory\Leonidas\Admin\Contracts\AdminPageLayoutInterface;
use WebTheory\Leonidas\Admin\Contracts\AdminPageLoadErrorInterface;
use WebTheory\Leonidas\Admin\Contracts\IconResolverInterface;

class AdminPage
{
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
     * @var IconResolverInterface
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
     * @var bool
     */
    protected $showInMenu = true;

    /**
     * The name that will be shown if the page has submenu items
     *
     * @var null|string
     */
    protected $subMenuName;

    /**
     * @var AdminPageLayoutInterface
     */
    protected $layout;

    /**
     * @var AdminPageLoadErrorInterface
     */
    protected $errorPage;

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
     *
     */
    public function __construct(string $menuSlug, AdminPageLayoutInterface $layout, ?string $capability = null)
    {
        $this->menuSlug = $menuSlug;
        $this->layout = $layout;
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
     * @return IconResolverInterface
     */
    public function getIcon(): IconResolverInterface
    {
        return $this->icon;
    }

    /**
     * Set icon
     *
     * @param IconResolverInterface $icon icon
     *
     * @return self
     */
    public function setIcon(IconResolverInterface $icon)
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
     * Get the value of layout
     *
     * @return AdminPageLayoutInterface
     */
    public function getLayout(): AdminPageLayoutInterface
    {
        return $this->layout;
    }

    /**
     * Set the value of layout
     *
     * @param AdminPageLayoutInterface $layout
     *
     * @return self
     */
    public function setLayout(AdminPageLayoutInterface $layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get the value of errorPage
     *
     * @return AdminPageLoadErrorInterface
     */
    public function getErrorPage(): AdminPageLoadErrorInterface
    {
        return $this->errorPage;
    }

    /**
     * Set the value of errorPage
     *
     * @param AdminPageLoadErrorInterface $errorPage
     *
     * @return self
     */
    public function setErrorPage(AdminPageLoadErrorInterface $errorPage)
    {
        $this->errorPage = $errorPage;

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
    public function getParentFileCallback(): ?callable
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
            [$this, 'renderPage']
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
            [$this, 'renderPage'],
            $this->icon->getIcon(),
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
    public function renderPage(array $args = [])
    {
        $request = ServerRequest::fromGlobals()
            ->withAttribute('args', $args);

        $this->layout->setTitle($this->pageTitle);

        if ($this->layout->shouldBeRendered($request)) {
            echo $this->layout->renderComponent($request);
        } else {
            echo $this->errorPage->renderComponent($request);
        }
    }
}
