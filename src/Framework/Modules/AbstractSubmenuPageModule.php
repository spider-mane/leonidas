<?php

namespace Leonidas\Framework\Modules;

use Closure;
use Leonidas\Contracts\Admin\Component\SubmenuPageInterface;
use Leonidas\Contracts\Admin\Component\SubmenuPageRegistrarInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\Traits\FluentlySetsPropertiesTrait;
use Leonidas\Framework\Modules\Traits\NestedPageModuleTrait;
use Leonidas\Hooks\TargetsAdminMenuHook;
use Leonidas\Hooks\TargetsAdminTitleHook;
use Leonidas\Hooks\TargetsParentFileHook;
use Leonidas\Hooks\TargetsSubmenuFileHook;
use Leonidas\Library\Admin\Registrar\SubmenuPageRegistrar;

abstract class AbstractSubmenuPageModule extends AbstractModule implements ModuleInterface
{
    use FluentlySetsPropertiesTrait;
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
        $this->init('admin_menu');

        $request = $this->getServerRequest()->withAttribute('context', $context);

        $this->addSubmenuPage();
    }

    protected function addSubmenuPage()
    {
        $this->getSubmenuPageRegistrar()->registerOne($this->getDefinition());
    }

    protected function renderSubmenuPage(array $args): void
    {
        $request = $this->getServerRequest()->withAttribute('args', $args);

        echo $this->renderAdminPage($request);
    }

    protected function initiationContexts(): array
    {
        return [
            'admin_menu' => $this->adminMenuRequiredProperties(),
        ];
    }

    protected function adminMenuRequiredProperties(): array
    {
        return ['definition', 'submenuPageLoader'];
    }

    protected function submenuPageRegistrar(): SubmenuPageRegistrarInterface
    {
        return new SubmenuPageRegistrar(
            Closure::fromCallable([$this, 'renderSubmenuPage'])
        );
    }

    abstract protected function definition(): SubmenuPageInterface;
}
