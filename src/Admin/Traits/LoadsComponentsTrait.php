<?php

namespace WebTheory\Leonidas\Admin\Traits;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\Contracts\ScreenComponentInterface;

trait LoadsComponentsTrait
{
    /**
     *
     */
    protected function maybeRenderComponent(ScreenComponentInterface $component, ServerRequestInterface $request): string
    {
        return $component->shouldBeRendered($request)
            ? $this->renderComponent($component, $request)
            : '';
    }

    /**
     *
     */
    protected function renderComponent(ScreenComponentInterface $component, ServerRequestInterface $request): string
    {
        return $component->render($request);
    }
}
