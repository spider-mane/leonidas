<?php

namespace WebTheory\Leonidas\Core\Contracts;

use Psr\Http\Message\ServerRequestInterface;

interface AuthTokenInterface
{
    /**
     *
     */
    public function validate(ServerRequestInterface $request): bool;
}
