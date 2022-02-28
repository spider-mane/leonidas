<?php

namespace Leonidas\Library\Admin\Loaders;

use Leonidas\Contracts\Admin\Components\MenuPageInterface;
use Leonidas\Contracts\Admin\Components\MenuPageLoaderInterface;

class MenuPageLoader implements MenuPageLoaderInterface
{
    /**
     * @var callable
     */
    protected $outputLoader;

    public function __construct(callable $outputLoader)
    {
        $this->outputLoader = $outputLoader;
    }

    public function getOutputLoader(): callable
    {
        return $this->outputLoader;
    }

    public function addOne(MenuPageInterface $page)
    {
        add_menu_page(
            $page->getPageTitle(),
            $page->getMenuTitle(),
            $page->getCapability(),
            $page->getMenuSlug(),
            $this->getOutputLoader(),
            $page->getIconUrl(),
            $page->getPosition()
        );

        $this->maybeAddSubMenuLink($page);
    }

    protected function maybeAddSubMenuLink(MenuPageInterface $page)
    {
        if ($title = $page->getTitleInSubmenu()) {
            add_submenu_page(
                $page->getMenuSlug(),
                $page->getPageTitle(),
                $title,
                $page->getCapability(),
                $page->getMenuSlug(),
                null,
                PHP_INT_MIN
            );
        }
    }
}
