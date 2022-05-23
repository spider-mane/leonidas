<?php

namespace Leonidas\Framework\Abstracts;

trait FluentlySetsPropertiesTrait
{
    protected function maybeSet(string ...$properties)
    {
        foreach ($properties as $property) {
            if (!$this->propertyIsSet($property)) {
                $this->setProperty($property);
            }
        }
    }

    protected function setProperties(string ...$properties)
    {
        foreach ($properties as $property) {
            $this->setProperty($property);
        }
    }

    protected function setProperty(string $property): void
    {
        $this->{$property} = ([$this, $property])();
    }

    protected function propertyIsSet(string $property): bool
    {
        return isset($this->{$property});
    }

    protected function init(string $context): void
    {
        $contexts = $this->initiationContexts();

        $this->maybeSet(...(array) $contexts[$context]);
    }

    protected function initiationContexts(): array
    {
        return [];
    }
}
