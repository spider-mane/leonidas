<?php

namespace Leonidas\Library\Core\Http\Form\Authenticators;

use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\FormValidatorInterface;

class CsrfCheck implements FormValidatorInterface
{
    /**
     * @var CsrfManagerInterface
     */
    protected $token;

    /**
     *
     */
    public function __construct(CsrfManagerInterface $token)
    {
        $this->token = $token;
    }

    /**
     *
     */
    public function isValid(ServerRequestInterface $request): bool
    {
        return $this->token->validate($request);
    }
}
