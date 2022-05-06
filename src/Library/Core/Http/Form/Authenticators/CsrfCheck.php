<?php

namespace Leonidas\Library\Core\Http\Form\Authenticators;

use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class CsrfCheck implements ServerRequestPolicyInterface
{
    /**
     * @var CsrfManagerInterface
     */
    protected $token;

    public function __construct(CsrfManagerInterface $token)
    {
        $this->token = $token;
    }

    public function approvesRequest(ServerRequestInterface $request): bool
    {
        return $this->token->validate($request);
    }
}
