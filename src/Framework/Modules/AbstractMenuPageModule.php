<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Admin\Components\MenuPageInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Traits\Registrars\RegistersMenuPage;

abstract class AbstractMenuPageModule extends AbstractAdminPageModule implements ModuleInterface
{
    use RegistersMenuPage {
        registerMenuPage as addPage;
        unregisterMenuPage as removePage;
    }

    protected MenuPageInterface $definition;

    protected function getMenuPage(): MenuPageInterface
    {
        return $this->definition;
    }

    protected function renderMenuPage(array $args): void
    {
        $this->renderPage($args);
    }
}
