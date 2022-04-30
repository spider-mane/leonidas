<?php

namespace Leonidas\Library\Abstracts;

use Closure;
use WebTheory\Collection\Contracts\CollectionKernelInterface;
use WebTheory\Collection\Kernel\CollectionKernel;

trait PoweredByCollectionKernelTrait
{
    use KernelPoweredCollectionTrait;

    public function serialize(): string
    {
        return serialize($this->toArray());
    }

    public function unserialize($serialized): void
    {
        $this->kernel = $this->createKernel(unserialize($serialized));
    }

    protected function initKernel(array $models)
    {
        $this->kernel = $this->createKernel($models);
    }

    protected function createKernel(array $models): CollectionKernelInterface
    {
        return new CollectionKernel(
            $models,
            Closure::fromCallable([$this, 'spawn']),
            $this->getKernelArg('ENTRY_IDENTIFIER', null),
            $this->getKernelArg('ENTRY_PROPERTY_ACCESSORS', []),
            $this->getKernelArg('COLLECTION_IS_MAP', false)
        );
    }

    protected function getKernelArg(string $arg, $default)
    {
        $arg = strtoupper($arg);

        return defined($arg) ? constant($arg) : $default;
    }
}
