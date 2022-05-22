<?php

namespace Leonidas\Framework\Module;

use Closure;
use Leonidas\Contracts\Admin\Component\Page\MenuPageInterface;
use Leonidas\Contracts\Admin\Registrar\MenuPageRegistrarInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\Abstracts\AdminPageModuleTrait;
use Leonidas\Framework\Module\Abstracts\FluentlySetsPropertiesTrait;
use Leonidas\Hooks\TargetsAdminMenuHook;
use Leonidas\Hooks\TargetsAdminTitleHook;
use Leonidas\Library\Admin\Registrar\MenuPageRegistrar;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractMenuPageModule extends AbstractModule implements ModuleInterface
{
    use AdminPageModuleTrait;
    use FluentlySetsPropertiesTrait;
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
        $this->init('admin_menu');

        $request = $this->getServerRequest()->withAttribute('context', $context);

        $this->addMenuPage($request);
    }

    protected function addMenuPage(ServerRequestInterface $request): void
    {
        $this->getMenuPageRegistrar()->registerOne($this->definition);
    }

    protected function renderMenuPage(array $args): void
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
        return ['definition', 'menuPageLoader'];
    }

    protected function menuPageRegistrar(): MenuPageRegistrarInterface
    {
        return new MenuPageRegistrar(
            Closure::fromCallable([$this, 'renderMenuPage'])
        );
    }

    abstract protected function definition(): MenuPageInterface;
}
