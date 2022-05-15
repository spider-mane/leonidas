<?php

namespace Leonidas\Contracts\Admin\Component;

use Psr\Http\Message\ServerRequestInterface;

interface AdminComponentInterface extends SimpleAdminComponentInterface
{
    public function shouldBeRendered(ServerRequestInterface $request): bool;
}
