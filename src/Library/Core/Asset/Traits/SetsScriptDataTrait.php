<?php

namespace Leonidas\Library\Core\Asset\Traits;

trait SetsScriptDataTrait
{
    /**
     * Set the value of shouldLoadInFooter
     *
     * @param bool $shouldLoadInFooter
     *
     * @return self
     */
    public function inFooter(?bool $shouldLoadInFooter)
    {
        $this->shouldLoadInFooter = $shouldLoadInFooter;

        return $this;
    }

    /**
     * Set the value of isAsync
     *
     * @param bool $isAsync
     *
     * @return self
     */
    public function async(bool $isAsync)
    {
        $this->isAsync = $isAsync;

        return $this;
    }

    /**
     * Set the value of isDeferred
     *
     * @param bool $isDeferred
     *
     * @return self
     */
    public function deferred(bool $isDeferred)
    {
        $this->isDeferred = $isDeferred;

        return $this;
    }

    /**
     * Set the value of integrity
     *
     * @param string $integrity
     *
     * @return self
     */
    public function integrity(string $integrity)
    {
        $this->integrity = $integrity;

        return $this;
    }

    /**
     * Set the value of isNoModule
     *
     * @param bool $isNoModule
     *
     * @return self
     */
    public function nomodule(bool $isNoModule)
    {
        $this->isNoModule = $isNoModule;

        return $this;
    }

    /**
     * Set the value of nonce
     *
     * @param string $nonce
     *
     * @return self
     */
    public function nonce(string $nonce)
    {
        $this->nonce = $nonce;

        return $this;
    }

    /**
     * Set the value of referrerPolicy
     *
     * @param string $referrerPolicy
     *
     * @return self
     */
    public function referrerpolicy(string $referrerPolicy)
    {
        $this->referrerPolicy = $referrerPolicy;

        return $this;
    }

    /**
     * Set the value of type
     *
     * @param string $type
     *
     * @return self
     */
    public function type(string $type)
    {
        $this->type = $type;

        return $this;
    }
}
