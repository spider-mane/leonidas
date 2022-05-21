<?php

namespace Leonidas\Library\Core\Http\Policy;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class NoPolicy implements ServerRequestPolicyInterface
{
    public function approvesRequest(ServerRequestInterface $request): bool
    {
        return true;
    }
}
