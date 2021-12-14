<?php

namespace Leonidas\Traits\Registrars;

use Leonidas\Contracts\Admin\Components\MenuPageInterface;

trait RegistersMenuPage
{
    protected function registerMenuPage()
    {
        $page = $this->getMenuPage();

        add_menu_page(
            $page->getPageTitle(),
            $page->getMenuTitle(),
            $page->getCapability(),
            htmlspecialchars($page->getMenuSlug()),
            $this->getRenderMenuPageCallback(),
            $page->getIconUrl(),
            $page->getPosition()
        );
    }

    protected function unregisterMenuPage()
    {
        remove_menu_page($this->getMenuPage()->getMenuSlug());
    }

    protected function getRenderMenuPageCallback()
    {
        return function (array $args) {
            $this->renderMenuPage($args);
        };
    }

    abstract protected function getMenuPage(): MenuPageInterface;

    abstract protected function renderMenuPage(array $args): void;
}
