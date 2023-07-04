<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Admin\Component\Page\InteriorPageInterface;
use Leonidas\Contracts\Admin\Registrar\InteriorPageRegistrarInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Abstracts\MustBeInitiatedContextuallyTrait;
use Leonidas\Framework\Module\Abstracts\Traits\NestedPageModuleTrait;
use Leonidas\Hooks\TargetsAdminMenuHook;
use Leonidas\Hooks\TargetsAdminTitleHook;
use Leonidas\Hooks\TargetsParentFileHook;
use Leonidas\Hooks\TargetsSubmenuFileHook;
use Psr\Http\Message\ServerRequestInterface;

abstract class InteriorPageModule extends Module implements ModuleInterface
{
    use MustBeInitiatedContextuallyTrait;
    use NestedPageModuleTrait;
    use TargetsAdminMenuHook;
    use TargetsAdminTitleHook;
    use TargetsParentFileHook;
    use TargetsSubmenuFileHook;

    protected InteriorPageInterface $definition;

    protected InteriorPageRegistrarInterface $interiorPageLoader;

    protected function getDefinition(): InteriorPageInterface
    {
        return $this->definition;
    }

    protected function getInteriorPageRegistrar(): InteriorPageRegistrarInterface
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
        $this->init('admin_menu')->addInteriorPage(
            $this->getServerRequest()->withAttribute('context', $context)
        );
    }

    protected function addInteriorPage(ServerRequestInterface $request): void
    {
        $this->getInteriorPageRegistrar()->registerOne(
            $this->getDefinition(),
            $request
        );
    }

    protected function adminMenuRequiredProperties(): array
    {
        return ['definition', 'interiorPageLoader'];
    }

    abstract protected function interiorPageRegistrar(): InteriorPageRegistrarInterface;

    abstract protected function definition(): InteriorPageInterface;
}
