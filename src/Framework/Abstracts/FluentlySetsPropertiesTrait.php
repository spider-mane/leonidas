<?php

namespace Leonidas\Framework\Abstracts;

trait FluentlySetsPropertiesTrait
{
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
}
