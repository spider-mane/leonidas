<?php

namespace Leonidas\Library\Core\Abstracts;

use Leonidas\Contracts\Collection\ObjectCollectionInterface;
use Traversable;
use WebTheory\Collection\Contracts\CollectionKernelInterface;

trait KernelPoweredCollectionTrait
{
    protected CollectionKernelInterface $kernel;

    public function count(): int
    {
        return $this->kernel->count();
    }

    public function values(): array
    {
        return $this->kernel->values();
    }

    public function toArray(): array
    {
        return $this->kernel->toArray();
    }

    public function toJson(): string
    {
        return $this->kernel->toJson();
    }

    public function getIterator(): Traversable
    {
        return $this->kernel;
    }

    public function jsonSerialize(): array
    {
        return $this->kernel->jsonSerialize();
    }

    protected function spawn(CollectionKernelInterface $kernel): ObjectCollectionInterface
    {
        $spawn = clone $this;

        $spawn->kernel = $kernel;

        return $spawn;
    }

    protected function expose(array ...$collections): array
    {
        return array_map(
            fn (ObjectCollectionInterface $collection) => $collection->toArray(),
            $collections
        );
    }
}
