<?php

namespace WebTheory\Leonidas\Traits;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Contracts\Admin\Components\AdminComponentInterface;

trait RendersComponentsTrait
{
    /**
     * @return string[]
     */
    protected function renderComponentsAsHtml(ServerRequestInterface $request): array
    {
        $components = [];

        foreach ($this->getComponents() as $component) {
            if ($component->shouldBeRendered($request)) {
                $components[] = $component->renderComponent($request);
            }
        }

        return $components;
    }

    /**
     * @return AdminComponentInterface[]
     */
    abstract protected function getComponents(): array;
}
