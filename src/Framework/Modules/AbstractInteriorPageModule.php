<?php

namespace Leonidas\Framework\Modules;

use Closure;
use Leonidas\Contracts\Admin\Components\InteriorPageInterface;
use Leonidas\Contracts\Admin\Components\InteriorPageLoaderInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\Traits\FluentlySetsPropertiesTrait;
use Leonidas\Framework\Modules\Traits\NestedPageModuleTrait;
use Leonidas\Hooks\TargetsAdminMenuHook;
use Leonidas\Hooks\TargetsAdminTitleHook;
use Leonidas\Hooks\TargetsParentFileHook;
use Leonidas\Hooks\TargetsSubmenuFileHook;
use Leonidas\Library\Admin\Loaders\InteriorPageLoader;

abstract class AbstractInteriorPageModule extends AbstractModule implements ModuleInterface
{
    use FluentlySetsPropertiesTrait;
    use NestedPageModuleTrait;
    use TargetsAdminMenuHook;
    use TargetsAdminTitleHook;
    use TargetsParentFileHook;
    use TargetsSubmenuFileHook;

    protected InteriorPageInterface $definition;

    protected InteriorPageLoaderInterface $interiorPageLoader;

    protected function getDefinition(): InteriorPageInterface
    {
        return $this->definition;
    }

    protected function getInteriorPageLoader(): InteriorPageLoaderInterface
    {
        return $this->interiorPageLoader;
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

        $this->addInteriorPage();
    }

    protected function addInteriorPage()
    {
        $this->getInteriorPageLoader()->addOne($this->getDefinition());
    }

    protected function renderInteriorPage(array $args): void
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
        return ['definition', 'interiorPageLoader'];
    }

    protected function interiorPageLoader(): InteriorPageLoaderInterface
    {
        return new InteriorPageLoader(
            Closure::fromCallable([$this, 'renderInteriorPage'])
        );
    }

    abstract protected function definition(): InteriorPageInterface;
}
