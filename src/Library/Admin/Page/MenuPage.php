<?php

namespace Leonidas\Library\Admin\Page;

use Leonidas\Contracts\Admin\Components\MenuPageInterface;
use Leonidas\Traits\CanBeRestrictedTrait;

class MenuPage extends AbstractAdminPage implements MenuPageInterface
{
    use CanBeRestrictedTrait;

    /**
     * @var null|string
     */
    protected $iconUrl;

    /**
     * The name that will be shown if the page has submenu items
     *
     * @var null|string
     */
    protected $titleInSubmenu;

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
     * Get the name that will be shown it the page has submenu items
     *
     * @return string
     */
    public function getTitleInSubmenu(): string
    {
        return $this->titleInSubmenu;
    }

    /**
     * Set the name that will be shown it the page has submenu items
     *
     * @param string $subMenuName
     *
     * @return self
     */
    public function setTitleInSubmenu(string $titleInSubmenu)
    {
        $this->titleInSubmenu = $titleInSubmenu;

        return $this;
    }
}
