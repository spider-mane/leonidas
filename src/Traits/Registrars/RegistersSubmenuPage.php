<?php

namespace Leonidas\Traits\Registrars;

use Leonidas\Contracts\Admin\Components\SubmenuPageInterface;

trait RegistersSubmenuPage
{
    protected function registerSubmenuPage()
    {
        $page = $this->getSubmenuPage();

        add_submenu_page(
            htmlspecialchars($page->getParentSlug()),
            $page->getPageTitle(),
            $page->getMenuTitle(),
            $page->getCapability(),
            htmlspecialchars($page->getMenuSlug()),
            $this->getRenderSubmenuPageCallback(),
            $page->getPosition()
        );
    }

    protected function unregisterSubmenuPage()
    {
        $page = $this->getSubmenuPage();

        remove_submenu_page(
            $page->getParentSlug(),
            $page->getMenuSlug()
        );

        return $this;
    }

    protected function getRenderSubmenuPageCallback()
    {
        return function (array $args) {
            $this->renderSubmenuPage($args);
        };
    }

    abstract protected function getSubmenuPage(): SubmenuPageInterface;

    abstract protected function renderSubmenuPage(array $args): void;
}
