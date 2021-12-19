<?php

namespace Leonidas\Framework\Modules\Traits;

trait MustBeInitiatedTrait
{
    protected bool $isInitiated = false;

    protected function maybeInit()
    {
        if (!$this->isInitiated()) {
            $this->init();
            $this->isInitiated = true;
        }
    }

    protected function isInitiated(): bool
    {
        return $this->isInitiated;
    }

    abstract protected function init();
}
