<?php

namespace Leonidas\Framework\Modules;

use Closure;
use Leonidas\Contracts\Admin\Components\MenuPageInterface;
use Leonidas\Contracts\Admin\Components\MenuPageLoaderInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\Traits\AdminPageModuleTrait;
use Leonidas\Framework\Modules\Traits\FluentlySetsPropertiesTrait;
use Leonidas\Library\Admin\Loaders\MenuPageLoader;
use Leonidas\Traits\Hooks\TargetsAdminMenuHook;
use Leonidas\Traits\Hooks\TargetsAdminTitleHook;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractMenuPageModule extends AbstractModule implements ModuleInterface
{
    use AdminPageModuleTrait;
    use FluentlySetsPropertiesTrait;
    use TargetsAdminMenuHook;
    use TargetsAdminTitleHook;

    protected MenuPageInterface $definition;

    protected MenuPageLoaderInterface $menuPageLoader;

    protected function getDefinition(): MenuPageInterface
    {
        return $this->definition;
    }

    protected function getMenuPageLoader(): MenuPageLoaderInterface
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
        $this->getMenuPageLoader()->addOne($this->definition);
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

    protected function menuPageLoader(): MenuPageLoaderInterface
    {
        return new MenuPageLoader(
            Closure::fromCallable([$this, 'renderMenuPage'])
        );
    }

    abstract protected function definition(): MenuPageInterface;
}
