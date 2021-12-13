<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Admin\Components\MenuPageInterface;
use Leonidas\Contracts\Extension\ModuleInterface;

abstract class AbstractMenuPageModule extends AbstractAdminPageModule implements ModuleInterface
{
    protected MenuPageInterface $definition;

    protected function addPage(): AbstractMenuPageModule
    {
        add_menu_page(
            $this->definition->getPageTitle(),
            $this->definition->getMenuTitle(),
            $this->definition->getCapability(),
            htmlspecialchars($this->definition->getMenuSlug()),
            fn (array $args) => $this->renderPage($args),
            $this->definition->getIconUrl(),
            $this->definition->getPosition(),
        );

        return $this;
    }

    protected function removePage(): AbstractMenuPageModule
    {
        remove_menu_page($this->definition->getMenuSlug());

        return $this;
    }
}
