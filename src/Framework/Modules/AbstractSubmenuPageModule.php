<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Admin\Components\SubmenuPageInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Traits\Hooks\TargetsParentFileHook;
use Leonidas\Traits\Hooks\TargetsSubmenuFileHook;
use Leonidas\Traits\Registrars\RegistersSubmenuPage;

abstract class AbstractSubmenuPageModule extends AbstractAdminPageModule implements ModuleInterface
{
    use TargetsSubmenuFileHook;
    use TargetsParentFileHook;
    use RegistersSubmenuPage {
        registerSubmenuPage as addPage;
        unregisterSubmenuPage as removePage;
    }

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

    protected function getSubmenuPage(): SubmenuPageInterface
    {
        return $this->definition;
    }

    protected function renderSubmenuPage(array $args): void
    {
        $this->renderPage($args);
    }
}
