<?php

namespace Leonidas\Library\Core\Http;

use Leonidas\Contracts\Http\ServerRequestPolicyInterface;
use Psr\Http\Message\ServerRequestInterface;

class DraconianPolicy implements ServerRequestPolicyInterface
{
    public function approvesRequest(ServerRequestInterface $request): bool
    {
        return false;
    }
}
