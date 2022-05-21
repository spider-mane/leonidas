<?php

namespace Leonidas\Library\Core\Http\Policy;

use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class CsrfCheck implements ServerRequestPolicyInterface
{
    protected CsrfManagerInterface $token;

    public function __construct(CsrfManagerInterface $token)
    {
        $this->token = $token;
    }

    public function approvesRequest(ServerRequestInterface $request): bool
    {
        return $this->token->validate($request);
    }
}
