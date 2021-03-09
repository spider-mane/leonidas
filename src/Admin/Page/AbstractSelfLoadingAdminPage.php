<?php

namespace WebTheory\Leonidas\Admin\Page;

use GuzzleHttp\Psr7\ServerRequest;
use WebTheory\Leonidas\Contracts\Admin\Components\AdminPageLayoutInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\AdminPageLoadErrorInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\AdminTitleResolverInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\ParentFileResolverInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\SubmenuFileResolverInterface;

abstract class AbstractSelfLoadingAdminPage
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
     * @var null|string
     */
    protected $iconUrl;

    /**
     * @var null|int
     */
    protected $position;

    /**
     * @var null|string
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
     * @var null|AdminTitleResolverInterface
     */
    protected $adminTitleResolver;

    /**
     * @see https://developer.wordpress.org/reference/hooks/submenu_file/
     *
     * @var null|SubmenuFileResolverInterface
     */
    protected $submenuFileResolver;

    /**
     * @see https://developer.wordpress.org/reference/hooks/parent_file/
     *
     * @var null|ParentFileResolverInterface
     */
    protected $parentFileResolver;

    /**
     * Get capability
     *
     * @return  string
     */
    public function getCapability(): string
    {
        return $this->capability;
    }

    /**
     * Get menu_slug
     *
     * @return  string
     */
    public function getMenuSlug(): string
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
     * @return string
     */
    public function getIconUrl(): string
    {
        return $this->iconUrl;
    }

    /**
     * Set icon
     *
     * @param string $iconUrl icon
     *
     * @return self
     */
    public function setIconUrl(string $iconUrl)
    {
        $this->iconUrl = $iconUrl;

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
     * Get the value of adminTitleResolver
     *
     * @return null|AdminTitleResolverInterface
     */
    public function getAdminTitleResolver(): ?AdminTitleResolverInterface
    {
        return $this->adminTitleResolver;
    }

    /**
     * Set the value of adminTitleResolver
     *
     * @param AdminTitleResolverInterface $adminTitleResolver
     *
     * @return self
     */
    public function setAdminTitleResolver(AdminTitleResolverInterface $adminTitleResolver)
    {
        $this->adminTitleResolver = $adminTitleResolver;

        return $this;
    }

    /**
     * Get the value of submenuFileResolver
     *
     * @return null|SubmenuFileResolverInterface
     */
    public function getSubmenuFileResolver(): ?SubmenuFileResolverInterface
    {
        return $this->submenuFileResolver;
    }

    /**
     * Set the value of submenuFileResolver
     *
     * @param SubmenuFileResolverInterface $submenuFileResolver
     *
     * @return self
     */
    public function setSubmenuFileResolver(SubmenuFileResolverInterface $submenuFileResolver)
    {
        $this->submenuFileResolver = $submenuFileResolver;

        return $this;
    }

    /**
     * Get the value of parentFileResolver
     *
     * @return null|ParentFileResolverInterface
     */
    public function getParentFileResolver(): ?ParentFileResolverInterface
    {
        return $this->parentFileResolver;
    }

    /**
     * Set the value of parentFileResolver
     *
     * @param ParentFileResolverInterface $parentFileResolver
     *
     * @return self
     */
    public function setParentFileResolver(ParentFileResolverInterface $parentFileResolver)
    {
        $this->parentFileResolver = $parentFileResolver;

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
    protected function addSubmenuPage()
    {
        add_submenu_page(
            htmlspecialchars($this->getParentSlug()),
            $this->getPageTitle(),
            $this->getMenuTitle(),
            $this->getCapability(),
            htmlspecialchars($this->getMenuSlug()),
            [$this, 'renderPage']
        );

        return $this;
    }

    /**
     *
     */
    protected function addMenuPage()
    {
        add_menu_page(
            $this->getPageTitle(),
            $this->getMenuTitle(),
            $this->getCapability(),
            htmlspecialchars($this->getMenuSlug()),
            [$this, 'renderPage'],
            htmlspecialchars($this->getIconUrl()),
            $this->getPosition()
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

        if (isset($this->adminTitleResolver)) {
            add_filter('admin_title', [$this, 'resolveParentFile'], null, PHP_INT_MAX);
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
        if (isset($this->submenuFileResolver)) {
            add_filter('submenu_file', [$this, 'resolveSubmenuFile'], null, PHP_INT_MAX);
        }

        if (isset($this->parentFileResolver)) {
            add_filter('parent_file', [$this, 'resolveParentFile'], null, PHP_INT_MAX);
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
    public function resolveAdminTitle(string $adminTitle, string $title)
    {
        return $this->adminTitleResolver->resolveAdminTitle($adminTitle, $title);
    }

    /**
     *
     */
    public function resolveSubmenuFile(string $submenuFile, string $parentFile)
    {
        return $this->submenuFileResolver->resolveSubmenuFile($submenuFile, $parentFile);
    }

    /**
     *
     */
    public function resolveParentFile(string $parentFile)
    {
        return $this->parentFileResolver->resolveParentFile($parentFile);
    }

    /**
     *
     */
    public function renderPage(array $args)
    {
        $this->layout->setTitle($this->pageTitle);

        $request = ServerRequest::fromGlobals()
            ->withAttribute('args', $args);

        if ($this->layout->shouldBeRendered($request)) {
            echo $this->layout->renderComponent($request);
        } else {
            echo $this->errorPage->renderComponent($request);
        }
    }
}
