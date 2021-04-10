<?php

namespace Leonidas\Library\Admin\Forms\Validators;

use Leonidas\Library\Core\Auth\Nonce;
use Psr\Http\Message\ServerRequestInterface;
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
