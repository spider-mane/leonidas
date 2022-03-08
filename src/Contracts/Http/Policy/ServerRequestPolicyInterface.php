<?php

namespace Leonidas\Contracts\Http\Policy;

use Psr\Http\Message\ServerRequestInterface;

interface ServerRequestPolicyInterface
{
    public function approvesRequest(ServerRequestInterface $request): bool;
}
