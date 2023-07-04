<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Admin\Component\Page\MenuPageInterface;
use Leonidas\Contracts\Admin\Registrar\MenuPageRegistrarInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Abstracts\MustBeInitiatedContextuallyTrait;
use Leonidas\Framework\Module\Abstracts\Traits\AdminPageModuleTrait;
use Leonidas\Hooks\TargetsAdminMenuHook;
use Leonidas\Hooks\TargetsAdminTitleHook;
use Psr\Http\Message\ServerRequestInterface;

abstract class MenuPageModule extends Module implements ModuleInterface
{
    use AdminPageModuleTrait;
    use MustBeInitiatedContextuallyTrait;
    use TargetsAdminMenuHook;
    use TargetsAdminTitleHook;

    protected MenuPageInterface $definition;

    protected MenuPageRegistrarInterface $menuPageLoader;

    protected function getDefinition(): MenuPageInterface
    {
        return $this->definition;
    }

    protected function getMenuPageRegistrar(): MenuPageRegistrarInterface
    {
        return $this->menuPageLoader;
    }

    public function hook(): void
    {
        $this->targetAdminMenuHook();
        $this->targetAdminTitleHook();
    }

    protected function doAdminMenuAction(string $context): void
    {
        $this->init('admin_menu')->addMenuPage(
            $this->getServerRequest()->withAttribute('context', $context)
        );
    }

    protected function addMenuPage(ServerRequestInterface $request): void
    {
        $this->getMenuPageRegistrar()->registerOne(
            $this->getDefinition(),
            $request
        );
    }

    protected function adminMenuRequiredProperties(): array
    {
        return ['definition', 'menuPageLoader'];
    }

    abstract protected function menuPageRegistrar(): MenuPageRegistrarInterface;

    abstract protected function definition(): MenuPageInterface;
}
