<?php

namespace WebTheory\Leonidas\Admin\Contracts;

use Psr\Http\Message\ServerRequestInterface;

interface AdminComponentInterface extends SimpleAdminComponentInterface
{
    /**
     *
     */
    public function shouldBeRendered(ServerRequestInterface $request): bool;
}
