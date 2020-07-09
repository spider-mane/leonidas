<?php

namespace WebTheory\Leonidas\Traits;

use WebTheory\Leonidas\Auth\Nonce;

trait HasNonceTrait
{
    /**
     * @var Nonce
     */
    protected $nonce;

    /**
     * Get the value of nonce
     *
     * @return Nonce
     */
    public function getNonce(): Nonce
    {
        return $this->nonce;
    }

    /**
     * Set the value of nonce
     *
     * @param Nonce $nonce
     *
     * @return self
     */
    public function setNonce(Nonce $nonce)
    {
        $this->nonce = $nonce;

        return $this;
    }

    /**
     *
     */
    protected function renderNonce(): string
    {
        return $this->nonce->field() . "\n";
    }

    /**
     *
     */
    protected function maybeRenderNonce(): string
    {
        return isset($this->nonce) ? $this->renderNonce() : '';
    }
}
