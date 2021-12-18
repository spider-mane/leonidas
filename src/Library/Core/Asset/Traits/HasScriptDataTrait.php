<?php

namespace Leonidas\Library\Core\Asset\Traits;

use Leonidas\Contracts\Ui\Asset\ScriptLocalizationInterface;

trait HasScriptDataTrait
{
    /**
     * Get the value of isInFooter
     *
     * @return bool
     */
    public function shouldLoadInFooter(): ?bool
    {
        return $this->shouldLoadInFooter;
    }

    public function getLocalization(): ?ScriptLocalizationInterface
    {
        return $this->localization;
    }

    /**
     * Get the value of isAsync
     *
     * @return bool
     */
    public function isAsync(): ?bool
    {
        return $this->isAsync;
    }

    /**
     * Get the value of isDeferred
     *
     * @return bool
     */
    public function isDeferred(): ?bool
    {
        return $this->isDeferred;
    }

    /**
     * Get the value of integrity
     *
     * @return string
     */
    public function getIntegrity(): ?string
    {
        return $this->integrity;
    }

    /**
     * Get the value of isNoModule
     *
     * @return bool
     */
    public function isNoModule(): ?bool
    {
        return $this->isNoModule;
    }

    /**
     * Get the value of nonce
     *
     * @return string
     */
    public function getNonce(): ?string
    {
        return $this->nonce;
    }

    /**
     * Get the value of referrerPolicy
     *
     * @return string
     */
    public function getReferrerPolicy(): ?string
    {
        return $this->referrerPolicy;
    }

    /**
     * Get the value of type
     *
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }
}
