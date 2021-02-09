<?php

namespace WebTheory\Leonidas\Admin\Traits;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\Contracts\AdminComponentInterface;

trait LoadsComponentsTrait
{
    /**
     *
     */
    protected function maybeRenderComponent(AdminComponentInterface $component, ServerRequestInterface $request): string
    {
        return $component->shouldBeRendered($request)
            ? $this->renderComponent($component, $request)
            : '';
    }

    /**
     *
     */
    protected function renderComponent(AdminComponentInterface $component, ServerRequestInterface $request): string
    {
        return $component->renderComponent($request);
    }
}
