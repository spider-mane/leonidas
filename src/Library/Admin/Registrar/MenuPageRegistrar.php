<?php

namespace Leonidas\Library\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\MenuPageInterface;
use Leonidas\Contracts\Admin\Component\MenuPageRegistrarInterface;
use Leonidas\Library\Admin\Registrar\Abstracts\AbstractRegistrar;

class MenuPageRegistrar extends AbstractRegistrar implements MenuPageRegistrarInterface
{
    public function registerOne(MenuPageInterface $page)
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
