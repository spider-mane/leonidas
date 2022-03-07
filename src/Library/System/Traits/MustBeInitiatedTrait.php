<?php

namespace Leonidas\Library\System\Traits;

trait MustBeInitiatedTrait
{
    protected bool $isInitiated = false;

    protected function maybeInit()
    {
        if (!$this->isInitiated()) {
            $this->initiate();
            $this->isInitiated = true;
        }
    }

    protected function isInitiated(): bool
    {
        return $this->isInitiated;
    }

    abstract protected function initiate();
}
