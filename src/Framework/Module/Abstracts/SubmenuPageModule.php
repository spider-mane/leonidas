<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Admin\Component\Page\SubmenuPageInterface;
use Leonidas\Contracts\Admin\Registrar\SubmenuPageRegistrarInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Abstracts\MustBeInitiatedContextuallyTrait;
use Leonidas\Framework\Module\Abstracts\Traits\NestedPageModuleTrait;
use Leonidas\Hooks\TargetsAdminMenuHook;
use Leonidas\Hooks\TargetsAdminTitleHook;
use Leonidas\Hooks\TargetsParentFileHook;
use Leonidas\Hooks\TargetsSubmenuFileHook;
use Psr\Http\Message\ServerRequestInterface;

abstract class SubmenuPageModule extends Module implements ModuleInterface
{
    use MustBeInitiatedContextuallyTrait;
    use NestedPageModuleTrait;
    use TargetsAdminMenuHook;
    use TargetsAdminTitleHook;
    use TargetsParentFileHook;
    use TargetsSubmenuFileHook;

    protected SubmenuPageInterface $definition;

    protected SubmenuPageRegistrarInterface $submenuPageLoader;

    protected function getDefinition(): SubmenuPageInterface
    {
        return $this->definition;
    }

    protected function getSubmenuPageRegistrar(): SubmenuPageRegistrarInterface
    {
        return $this->submenuPageLoader;
    }

    public function hook(): void
    {
        $this->targetAdminMenuHook();
        $this->targetAdminTitleHook();
        $this->targetSubmenuFileHook();
        $this->targetParentFileHook();
    }

    protected function doAdminMenuAction(string $context): void
    {
        $this->init('admin_menu')->addSubmenuPage(
            $this->getServerRequest()->withAttribute('context', $context)
        );
    }

    protected function addSubmenuPage(ServerRequestInterface $request): void
    {
        $this->getSubmenuPageRegistrar()->registerOne(
            $this->getDefinition(),
            $request
        );
    }

    protected function adminMenuRequiredProperties(): array
    {
        return ['definition', 'submenuPageLoader'];
    }

    abstract protected function submenuPageRegistrar(): SubmenuPageRegistrarInterface;

    abstract protected function definition(): SubmenuPageInterface;
}
