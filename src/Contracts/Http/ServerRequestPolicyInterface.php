<?php

namespace Leonidas\Contracts\Http;

use Psr\Http\Message\ServerRequestInterface;

interface ServerRequestPolicyInterface
{
    public function approvesRequest(ServerRequestInterface $request): bool;
}
