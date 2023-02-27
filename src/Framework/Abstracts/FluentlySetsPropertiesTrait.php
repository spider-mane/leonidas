<?php

namespace Leonidas\Framework\Abstracts;

use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;
use RuntimeException;

trait FluentlySetsPropertiesTrait
{
    use ConvertsCaseTrait;

    protected array $initiationContexts;

    protected function maybeSet(string ...$properties): void
    {
        foreach ($properties as $property) {
            if (!$this->propertyIsSet($property)) {
                $this->setProperty($property);
            }
        }
    }

    protected function setProperties(string ...$properties): void
    {
        foreach ($properties as $property) {
            $this->setProperty($property);
        }
    }

    protected function setProperty(string $property): void
    {
        $this->{$property} = ([$this, $property])();
    }

    protected function getProperty(string $property): mixed
    {
        return $this->{$property} ??= ([$this, $property])();
    }

    protected function propertyIsSet(string $property): bool
    {
        return isset($this->{$property});
    }

    protected function init(string $context): void
    {
        $contexts = $this->getProperty('initiationContexts');
        $resolved = $contexts[$context] ?? null;

        if (!isset($resolved)) {
            $method = [$this, $this->suffixCamel('RequiredProperties', $context)];

            if (is_callable($method)) {
                $resolved = $this->initiationContexts[$context] = $method();
            } else {
                throw new RuntimeException(
                    "Could not resolve initiation for context \"$context.\" Make sure method \"$method\" exists and is not private."
                );
            }
        }

        $this->maybeSet(...(array) $resolved);
    }

    /**
     * @return array<string, string|array<string>>
     */
    protected function initiationContexts(): array
    {
        return [];
    }
}
