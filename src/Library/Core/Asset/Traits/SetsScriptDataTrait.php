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
    public function setShouldLoadInFooter(?bool $shouldLoadInFooter)
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
    public function setIsAsync(bool $isAsync)
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
    public function setIsDeferred(bool $isDeferred)
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
    public function setIntegrity(string $integrity)
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
    public function setIsNoModule(bool $isNoModule)
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
    public function setNonce(string $nonce)
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
    public function setReferrerPolicy(string $referrerPolicy)
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
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }
}
