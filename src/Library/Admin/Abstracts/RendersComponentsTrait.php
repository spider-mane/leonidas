<?php

namespace Leonidas\Library\Admin\Abstracts;

use Leonidas\Contracts\Admin\Components\AdminComponentInterface;
use Psr\Http\Message\ServerRequestInterface;

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
