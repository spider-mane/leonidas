<?php

namespace WebTheory\Leonidas\Admin\Forms\Validators;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Core\Auth\Nonce;
use WebTheory\Saveyour\Contracts\FormValidatorInterface;

class WpNonceValidator implements FormValidatorInterface
{
    /**
     * @var Nonce
     */
    protected $nonce;

    /**
     *
     */
    public function __construct(Nonce $nonce)
    {
        $this->nonce = $nonce;
    }

    /**
     *
     */
    public function isValid(ServerRequestInterface $request): bool
    {
        return $this->nonce->validate($request);
    }
}
