<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Admin\Components\SubmenuPageInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Traits\Hooks\TargetsAdminMenuHook;
use Leonidas\Traits\Hooks\TargetsAdminNoticesHook;
use Leonidas\Traits\Hooks\TargetsAdminTitleHook;
use Leonidas\Traits\Hooks\TargetsParentFileHook;
use Leonidas\Traits\Hooks\TargetsSubmenuFileHook;
use Leonidas\Traits\Hooks\TargetsWpRedirectHook;

abstract class AbstractSubmenuPageModule extends AbstractAdminPageModule implements ModuleInterface
{
    use TargetsSubmenuFileHook;
    use TargetsParentFileHook;

    protected SubmenuPageInterface $definition;

    public function hook(): void
    {
        parent::hook();

        $this->targetSubmenuFileHook();
        $this->targetParentFileHook();
    }

    protected function filterSubmenuFile(string $submenuFile, string $parentFile): string
    {
        return $this->definition->defineSubmenuFile($submenuFile, $parentFile);
    }

    protected function filterParentFile(string $parentFile): string
    {
        return $this->definition->defineParentFile($parentFile);
    }

    protected function addPage(): AbstractSubmenuPageModule
    {
        add_submenu_page(
            htmlspecialchars($this->definition->getParentSlug()),
            $this->definition->getPageTitle(),
            $this->definition->getMenuTitle(),
            $this->definition->getCapability(),
            htmlspecialchars($this->definition->getMenuSlug()),
            fn (array $args) => $this->renderPage($args),
        );

        return $this;
    }

    protected function removePage(): AbstractSubmenuPageModule
    {
        remove_submenu_page(
            $this->definition->getParentSlug(),
            $this->definition->getMenuSlug()
        );

        return $this;
    }
}
