<?php

namespace Leonidas\Framework\Abstracts;

use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;
use RuntimeException;

trait FluentlySetsPropertiesTrait
{
    use ConvertsCaseTrait;

    protected array $initiationContexts;

    protected function get(string $property): mixed
    {
        return $this->{$property} ??= ([$this, $property])();
    }

    /**
     * @return $this
     */
    protected function set(string $property): static
    {
        $this->{$property} = ([$this, $property])();

        return $this;
    }

    protected function isset(string $property): bool
    {
        return isset($this->{$property});
    }

    /**
     * @return $this
     */
    protected function setList(string ...$properties): static
    {
        foreach ($properties as $property) {
            $this->set($property);
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function maybeSet(string ...$properties): static
    {
        foreach ($properties as $property) {
            if (!$this->isset($property)) {
                $this->set($property);
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function init(string $context): static
    {
        $contexts = $this->get('initiationContexts');
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

        return $this;
    }

    /**
     * @return array<string, string|array<string>>
     */
    protected function initiationContexts(): array
    {
        return [];
    }
}
