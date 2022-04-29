<?php

namespace Leonidas\Library\System\Model\Abstracts;

use Closure;
use IteratorAggregate;
use Leonidas\Contracts\System\Model\SystemModelCollectionInterface;
use Traversable;
use WebTheory\Collection\Contracts\CollectionKernelInterface;
use WebTheory\Collection\Kernel\CollectionKernel;

abstract class AbstractSystemModelCollection implements SystemModelCollectionInterface, IteratorAggregate
{
    protected const MODEL_IDENTIFIER = 'id';

    protected const COLLECTION_IS_MAP = true;

    protected const MODEL_PROPERTY_ACCESSORS = [];

    protected CollectionKernelInterface $kernel;

    protected function __construct(array $models)
    {
        $this->kernel = $this->createKernel($models);
    }

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

    public function serialize(): string
    {
        return serialize($this->toArray());
    }

    public function unserialize($serialized): void
    {
        $this->kernel = $this->createKernel(unserialize($serialized));
    }

    public function jsonSerialize(): array
    {
        return $this->kernel->jsonSerialize();
    }

    protected function createKernel(array $models): CollectionKernelInterface
    {
        return new CollectionKernel(
            $models,
            Closure::fromCallable([$this, 'spawn']),
            static::MODEL_IDENTIFIER,
            static::MODEL_PROPERTY_ACCESSORS,
            static::COLLECTION_IS_MAP
        );
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
