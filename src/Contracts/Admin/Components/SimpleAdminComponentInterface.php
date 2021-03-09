<?php

namespace WebTheory\Leonidas\Contracts\Admin\Components;

use Psr\Http\Message\ServerRequestInterface;

interface SimpleAdminComponentInterface
{
    /**
     *
     */
    public function renderComponent(ServerRequestInterface $request): string;
}
