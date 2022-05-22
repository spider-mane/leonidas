<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Hooks\TargetsAdminInitHook;
use Leonidas\Hooks\TargetsCurrentScreenHook;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Http\Request;
use WP_Screen;

abstract class AdminScreenActionModule extends Module implements ModuleInterface
{
    use TargetsAdminInitHook;
    use TargetsCurrentScreenHook;

    public function hook(): void
    {
        $this->targetCurrentScreenHook();

        if ($this->ajaxActions()) {
            $this->targetAdminInitHook();
        }
    }

    protected function doCurrentScreenAction(WP_Screen $screen): void
    {
        if (!in_array($screen->base, $this->bases())) {
            return;
        }

        foreach ($this->screens() as $property => $value) {
            if ($screen->{$property} !== $value) {
                return;
            }
        }

        $request = $this->getServerRequest()->withAttribute('screen', $screen);

        $this->action($request);
    }

    protected function doAdminInitAction(): void
    {
        if (true !== wp_doing_ajax()) {
            return;
        }

        $request = $this->getServerRequest();

        if (!in_array(Request::var($request, 'action'), $this->ajaxActions())) {
            return;
        }

        $this->action($request);
    }

    protected function ajaxActions(): array
    {
        return [];
    }

    abstract protected function action(ServerRequestInterface $request): void;

    abstract protected function screens(): array;

    abstract protected function bases(): array;
}
