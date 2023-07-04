<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Admin\Component\Page\FlexPageInterface;
use Leonidas\Contracts\Admin\Registrar\FlexPageRegistrarInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Abstracts\MustBeInitiatedContextuallyTrait;
use Leonidas\Framework\Module\Abstracts\Traits\NestedPageModuleTrait;
use Leonidas\Hooks\TargetsAdminMenuHook;
use Leonidas\Hooks\TargetsAdminTitleHook;
use Leonidas\Hooks\TargetsParentFileHook;
use Leonidas\Hooks\TargetsSubmenuFileHook;
use Psr\Http\Message\ServerRequestInterface;

abstract class FlexPageModule extends Module implements ModuleInterface
{
    use MustBeInitiatedContextuallyTrait;
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
        $this->init('admin_menu')->addFlexPage(
            $this->getServerRequest()->withAttribute('context', $context)
        );
    }

    protected function addFlexPage(ServerRequestInterface $request): void
    {
        $this->getFlexPageRegistrar()->registerOne(
            $this->getDefinition(),
            $request
        );
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
        return $this->isset('definition')
            && $this->definitionIsNested()
            && $this->getDefinition()->getMenuSlug() === $submenuFile;
    }

    protected function isMatchingParentFile(string $parentFile): bool
    {
        return $this->isset('definition')
            && $this->definitionIsNested()
            && $this->getDefinition()->getParentSlug() === $parentFile;
    }

    protected function adminMenuRequiredProperties(): array
    {
        return ['definition', 'flexPageLoader'];
    }

    abstract protected function flexPageRegistrar(): FlexPageRegistrarInterface;

    abstract protected function definition(): FlexPageInterface;
}
