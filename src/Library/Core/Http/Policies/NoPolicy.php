<?php

namespace Leonidas\Library\Core\Http\Policies;

use Leonidas\Contracts\Http\Policy\ServerRequestPolicyInterface;
use Psr\Http\Message\ServerRequestInterface;

class NoPolicy implements ServerRequestPolicyInterface
{
    public function approvesRequest(ServerRequestInterface $request): bool
    {
        return true;
    }
}