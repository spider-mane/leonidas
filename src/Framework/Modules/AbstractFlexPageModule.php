<?php

namespace Leonidas\Framework\Modules;

use Closure;
use Leonidas\Contracts\Admin\Components\FlexPageInterface;
use Leonidas\Contracts\Admin\Components\FlexPageLoaderInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\Traits\FluentlySetsPropertiesTrait;
use Leonidas\Framework\Modules\Traits\NestedPageModuleTrait;
use Leonidas\Library\Admin\Loaders\FlexPageLoader;
use Leonidas\Traits\Hooks\TargetsAdminMenuHook;
use Leonidas\Traits\Hooks\TargetsAdminTitleHook;
use Leonidas\Traits\Hooks\TargetsParentFileHook;
use Leonidas\Traits\Hooks\TargetsSubmenuFileHook;

abstract class AbstractFlexPageModule extends AbstractModule implements ModuleInterface
{
    use FluentlySetsPropertiesTrait;
    use NestedPageModuleTrait;
    use TargetsAdminMenuHook;
    use TargetsAdminTitleHook;
    use TargetsParentFileHook;
    use TargetsSubmenuFileHook;

    protected FlexPageInterface $definition;

    protected FlexPageLoaderInterface $flexPageLoader;

    protected function getDefinition(): FlexPageInterface
    {
        return $this->definition;
    }

    protected function getFlexPageLoader(): FlexPageLoaderInterface
    {
        return $this->flexPageLoader;
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

        $this->addFlexPage();
    }

    protected function addFlexPage()
    {
        $this->getFlexPageLoader()->addOne($this->getDefinition());
    }

    protected function renderFlexPage(array $args): void
    {
        $request = $this->getServerRequest()->withAttribute('args', $args);

        echo $this->renderAdminPage($request);
    }

    protected function getDefinitionContext(): string
    {
        return $this->getDefinition()->getContext()->value;
    }

    protected function definitionIsNested(): bool
    {
        return in_array($this->getDefinitionContext(), ['submenu', 'interior']);
    }

    protected function isMatchingSubmenuFile(string $submenuFile): bool
    {
        return $this->propertyIsSet('definition')
            && $this->definitionIsNested()
            && $this->getDefinition()->getMenuSlug() === $submenuFile;
    }

    protected function isMatchingParentFile(string $parentFile): bool
    {
        return $this->propertyIsSet('definition')
            && $this->definitionIsNested()
            && $this->getDefinition()->getParentSlug() === $parentFile;
    }

    protected function initiationContexts(): array
    {
        return [
            'admin_menu' => $this->adminMenuRequiredProperties(),
        ];
    }

    protected function adminMenuRequiredProperties(): array
    {
        return ['definition', 'flexPageLoader'];
    }

    protected function flexPageLoader(): FlexPageLoaderInterface
    {
        return new FlexPageLoader(
            Closure::fromCallable([$this, 'renderFlexPage'])
        );
    }

    abstract protected function definition(): FlexPageInterface;
}
