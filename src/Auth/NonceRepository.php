<?php

namespace WebTheory\Leonidas\Auth;

class NonceRepository
{
    /**
     * @var Nonce[]
     */
    protected $nonces;

    /**
     *
     */
    public function __construct(Nonce ...$nonces)
    {
        array_walk($nonces, [$this, 'addNonce']);
    }

    /**
     * Get the value of nonces
     *
     * @return Nonce[]
     */
    public function getNonces(): array
    {
        return $this->nonces;
    }

    /**
     *
     */
    public function getNonce(string $name): ?Nonce
    {
        return $this->nonces[$name] ?? null;
    }

    /**
     *
     */
    public function addNonce(Nonce $nonce)
    {
        $this->nonces[$nonce->getName()] = $nonce;

        return $this;
    }
}
