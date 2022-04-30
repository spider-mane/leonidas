<?php

namespace Leonidas\Library\System\Model\Abstracts;

use Closure;
use IteratorAggregate;
use Leonidas\Contracts\System\Model\SystemModelCollectionInterface;
use WebTheory\Collection\Contracts\CollectionKernelInterface;
use WebTheory\Collection\Kernel\CollectionKernel;

abstract class AbstractSystemModelCollection implements SystemModelCollectionInterface, IteratorAggregate
{
    use PoweredByKernelTrait;

    protected const MODEL_IDENTIFIER = 'id';

    protected const COLLECTION_IS_MAP = true;

    protected const MODEL_PROPERTY_ACCESSORS = [];

    protected function __construct(array $models)
    {
        $this->kernel = $this->createKernel($models);
    }

    public function serialize(): string
    {
        return serialize($this->toArray());
    }

    public function unserialize($serialized): void
    {
        $this->kernel = $this->createKernel(unserialize($serialized));
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
}
