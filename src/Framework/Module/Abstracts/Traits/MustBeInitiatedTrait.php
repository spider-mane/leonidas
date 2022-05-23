<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

use Leonidas\Framework\Abstracts\FluentlySetsPropertiesTrait;

trait MustBeInitiatedTrait
{
    use FluentlySetsPropertiesTrait {
        init as setPropertiesForContext;
    }

    protected bool $isInitiated = false;

    protected array $initiatedContexts = [];

    protected function isInitiated(): bool
    {
        return $this->isInitiated;
    }

    protected function contextIsInitiated(string $context): bool
    {
        return in_array($context, $this->initiatedContexts);
    }

    protected function init(string $context): void
    {
        $this->setPropertiesForContext($context);

        $this->isInitiated = true;
        $this->initiatedContexts[] = $context;
    }

    protected function initWith(string ...$properties): void
    {
        $this->setProperties(...$properties);

        $this->isInitiated = true;
    }

    protected function maybeInitWith(string ...$properties): void
    {
        $this->maybeSet(...$properties);

        $this->isInitiated = true;
    }
}
