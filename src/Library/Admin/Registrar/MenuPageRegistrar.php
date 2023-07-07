<?php

namespace Leonidas\Library\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\Page\MenuPageInterface;
use Leonidas\Contracts\Admin\Registrar\MenuPageRegistrarInterface;
use Leonidas\Library\Admin\Registrar\Abstracts\AbstractAdminPageRegistrar;
use Psr\Http\Message\ServerRequestInterface;

class MenuPageRegistrar extends AbstractAdminPageRegistrar implements MenuPageRegistrarInterface
{
    public function registerOne(MenuPageInterface $page, ServerRequestInterface $request): void
    {
        add_menu_page(
            $page->getPageTitle(),
            $page->getMenuTitle(),
            $page->getCapability(),
            $page->getMenuSlug(),
            $callback = $this->getRenderingCallback($page, $request),
            $page->getIconUrl(),
            $page->getPosition()
        );

        $this->maybeAddSubMenuLink($page, $callback);
    }

    protected function maybeAddSubMenuLink(MenuPageInterface $page, callable $callback): void
    {
        if ($title = $page->getTitleInSubmenu()) {
            add_submenu_page(
                $page->getMenuSlug(),
                $page->getPageTitle(),
                $title,
                $page->getCapability(),
                $page->getMenuSlug(),
                $callback,
                PHP_INT_MIN
            );
        }
    }
}
