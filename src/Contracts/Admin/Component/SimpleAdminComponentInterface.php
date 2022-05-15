<?php

namespace Leonidas\Contracts\Admin\Component;

use Psr\Http\Message\ServerRequestInterface;

interface SimpleAdminComponentInterface
{
    public function renderComponent(ServerRequestInterface $request): string;
}
