<?php

namespace WebTheory\Leonidas\Admin\Contracts;

use Psr\Http\Message\ServerRequestInterface;

interface AdminComponentInterface
{
    /**
     *
     */
    public function renderComponent(ServerRequestInterface $request): string;

    /**
     *
     */
    public function componentShouldRender(ServerRequestInterface $request): bool;
}
