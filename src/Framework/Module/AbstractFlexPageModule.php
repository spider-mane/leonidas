<?php

namespace Leonidas\Framework\Module;

use Closure;
use Leonidas\Contracts\Admin\Component\Page\FlexPageInterface;
use Leonidas\Contracts\Admin\Registrar\FlexPageRegistrarInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\Traits\FluentlySetsPropertiesTrait;
use Leonidas\Framework\Module\Traits\NestedPageModuleTrait;
use Leonidas\Hooks\TargetsAdminMenuHook;
use Leonidas\Hooks\TargetsAdminTitleHook;
use Leonidas\Hooks\TargetsParentFileHook;
use Leonidas\Hooks\TargetsSubmenuFileHook;
use Leonidas\Library\Admin\Registrar\FlexPageRegistrar;

abstract class AbstractFlexPageModule extends AbstractModule implements ModuleInterface
{
    use FluentlySetsPropertiesTrait;
    use NestedPageModuleTrait;
    use TargetsAdminMenuHook;
    use TargetsAdminTitleHook;
    use TargetsParentFileHook;
    use TargetsSubmenuFileHook;

    protected FlexPageInterface $definition;

    protected FlexPageRegistrarInterface $flexPageLoader;

    protected function getDefinition(): FlexPageInterface
    {
        return $this->definition;
    }

    protected function getFlexPageRegistrar(): FlexPageRegistrarInterface
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
        $this->getFlexPageRegistrar()->registerOne($this->getDefinition());
    }

    protected function renderFlexPage(array $args): void
    {
        $request = $this->getServerRequest()->withAttribute('args', $args);

        echo $this->renderAdminPage($request);
    }

    protected function getDefinitionContext(): string
    {
        return $this->getDefinition()->getContext()->getValue();
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

    protected function flexPageRegistrar(): FlexPageRegistrarInterface
    {
        return new FlexPageRegistrar(
            Closure::fromCallable([$this, 'renderFlexPage'])
        );
    }

    abstract protected function definition(): FlexPageInterface;
}
