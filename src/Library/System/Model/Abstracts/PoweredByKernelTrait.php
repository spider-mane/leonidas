<?php

namespace Leonidas\Library\System\Model\Abstracts;

use Leonidas\Contracts\System\Model\SystemModelCollectionInterface;
use Traversable;
use WebTheory\Collection\Contracts\CollectionKernelInterface;

trait PoweredByKernelTrait
{
    protected CollectionKernelInterface $kernel;

    public function map(callable $callback): array
    {
        return $this->kernel->map($callback);
    }

    public function walk(callable $callback): void
    {
        $this->kernel->walk($callback);
    }

    public function foreach(callable $callback): void
    {
        $this->kernel->foreach($callback);
    }

    public function extract(string $property): array
    {
        return $this->kernel->column($property);
    }

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

    protected function spawn(CollectionKernelInterface $kernel): AbstractSystemModelCollection
    {
        $spawn = clone $this;

        $spawn->kernel = $kernel;

        return $spawn;
    }

    protected function expose(array ...$collections): array
    {
        return array_map(
            fn (SystemModelCollectionInterface $collection) => $collection->toArray(),
            $collections
        );
    }
}
