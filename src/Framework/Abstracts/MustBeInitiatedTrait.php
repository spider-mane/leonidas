<?php

namespace Leonidas\Framework\Abstracts;

trait MustBeInitiatedTrait
{
    use FluentlySetsPropertiesTrait;

    protected bool $isInitiated = false;

    protected function isInitiated(): bool
    {
        return $this->isInitiated;
    }

    /**
     * @return $this
     */
    protected function init(string ...$properties): static
    {
        $this->setList(...$properties)->isInitiated = true;

        return $this;
    }
}
