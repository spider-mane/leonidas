<?php

namespace WebTheory\Leonidas\Admin\Page;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\Contracts\AdminPageInterface;
use WebTheory\Leonidas\Admin\Contracts\AdminPageLayoutInterface;
use WebTheory\Leonidas\Admin\Contracts\AdminPageLoadErrorInterface;
use WebTheory\Leonidas\Admin\Contracts\AdminTitleResolverInterface;
use WebTheory\Leonidas\Admin\Contracts\ParentFileResolverInterface;
use WebTheory\Leonidas\Admin\Contracts\SubmenuFileResolverInterface;
use WebTheory\Leonidas\Admin\Traits\CanBeRestrictedTrait;

abstract class AbstractAdminPage
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
     * @see https://developer.wordpress.org/reference/hooks/admin_title/
     *
     * @var null|AdminTitleResolverInterface
     */
    protected $adminTitleResolver;

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
    public function getPageTitle(): string
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
    public function getMenuTitle(): string
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
     * Get the value of layout
     *
     * @return AdminPageLayoutInterface
     */
    public function getLayout(): AdminPageLayoutInterface
    {
        return $this->layout;
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

    public function renderComponent(ServerRequestInterface $request): string
    {
        return $this->getLayout()->renderComponent($request);
    }

    public function defineAdminTitle(string $adminTitle, string $title): string
    {
        return $this->getAdminTitleResolver()->resolveAdminTitle($adminTitle, $title);
    }
}
