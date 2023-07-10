<?php

namespace Leonidas\Library\Core\Abstracts;

use Closure;
use Leonidas\Library\Core\Util\ClassConst;
use WebTheory\Collection\Contracts\CollectionKernelInterface;
use WebTheory\Collection\Kernel\CollectionKernel;

trait PoweredByCollectionKernelTrait
{
    use KernelPoweredCollectionTrait;

    public function __serialize(): array
    {
        return $this->values();
    }

    public function __unserialize(array $data): void
    {
        $this->initKernel($data);
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
            ClassConst::optional($this, 'ENTRY_IDENTIFIER', null),
            ClassConst::optional($this, 'ENTRY_PROPERTY_ACCESSORS', []),
            ClassConst::optional($this, 'COLLECTION_IS_MAP', false)
        );
    }
}
