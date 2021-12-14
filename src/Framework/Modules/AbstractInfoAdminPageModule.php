<?php

namespace Leonidas\Framework\Modules;

use DateInterval;
use GuzzleHttp\Psr7\Request;
use Leonidas\Contracts\Admin\Components\AdminPageInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Traits\Hooks\TargetsAdminMenuHook;
use Leonidas\Traits\Hooks\TargetsAdminNoticesHook;
use Leonidas\Traits\Hooks\TargetsAdminTitleHook;
use Leonidas\Traits\Hooks\TargetsWpRedirectHook;
use Psr\SimpleCache\CacheInterface;
use Stringable;

abstract class AbstractInfoAdminPageModule extends AbstractModule implements ModuleInterface
{
    use TargetsAdminMenuHook;
    use TargetsAdminTitleHook;

    protected AdminPageInterface $definition;

    protected AdminPageInterface $fallback;

    public function hook(): void
    {
        $this->targetAdminMenuHook();
        $this->targetAdminTitleHook();
    }

    protected function init()
    {
        $definition = $this->definition();
        $request = $this->getServerRequest();

        $this->definition = $definition->shouldBeRendered($request)
            ? $definition
            : $this->fallback();

        return $this;
    }

    protected function doAdminMenuAction(string $context): void
    {
        $this->init();
        $this->addPage();
        $this->configurePage();
    }

    protected function filterAdminTitle(string $adminTitle, string $title): string
    {
        return $this->definition->defineAdminTitle($adminTitle, $title);
    }


    protected function configurePage()
    {
        if (!$this->definition->isShownInMenu()) {
            $this->removePage();
        }

        return $this;
    }

    protected function renderPage(array $args): void
    {
        $request = $this->getServerRequest()->withAttribute('args', $args);

        echo $this->definition->renderComponent($request);
    }

    abstract protected function addPage();

    abstract protected function removePage();

    abstract protected function definition(): AdminPageInterface;

    abstract protected function fallback(): AdminPageInterface;
}
