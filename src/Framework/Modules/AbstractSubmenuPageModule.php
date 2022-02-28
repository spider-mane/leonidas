<?php

namespace Leonidas\Framework\Modules;

use Closure;
use Leonidas\Contracts\Admin\Components\SubmenuPageInterface;
use Leonidas\Contracts\Admin\Components\SubmenuPageLoaderInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\Traits\FluentlySetsPropertiesTrait;
use Leonidas\Framework\Modules\Traits\NestedPageModuleTrait;
use Leonidas\Library\Admin\Loaders\SubmenuPageLoader;
use Leonidas\Traits\Hooks\TargetsAdminMenuHook;
use Leonidas\Traits\Hooks\TargetsAdminTitleHook;
use Leonidas\Traits\Hooks\TargetsParentFileHook;
use Leonidas\Traits\Hooks\TargetsSubmenuFileHook;

abstract class AbstractSubmenuPageModule extends AbstractModule implements ModuleInterface
{
    use FluentlySetsPropertiesTrait;
    use NestedPageModuleTrait;
    use TargetsAdminMenuHook;
    use TargetsAdminTitleHook;
    use TargetsParentFileHook;
    use TargetsSubmenuFileHook;

    protected SubmenuPageInterface $definition;

    protected SubmenuPageLoaderInterface $submenuPageLoader;

    protected function getDefinition(): SubmenuPageInterface
    {
        return $this->definition;
    }

    protected function getSubmenuPageLoader(): SubmenuPageLoaderInterface
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

        $this->addSubmenuPage($request);
    }

    protected function addSubmenuPage()
    {
        $this->getSubmenuPageLoader()->addOne($this->getDefinition());
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

    protected function submenuPageLoader(): SubmenuPageLoaderInterface
    {
        return new SubmenuPageLoader(
            Closure::fromCallable([$this, 'renderSubmenuPage'])
        );
    }

    abstract protected function definition(): SubmenuPageInterface;
}
