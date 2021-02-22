<?php

namespace WebTheory\Leonidas\Admin\Contracts;

use Psr\Http\Message\ServerRequestInterface;

interface SimpleAdminComponentInterface
{
    /**
     *
     */
    public function renderComponent(ServerRequestInterface $request): string;
}
