<?php

namespace Leonidas\Library\System\Model\Abstracts;

use Closure;
use Leonidas\Library\Abstracts\PoweredByCollectionKernelTrait;
use WebTheory\Collection\Contracts\CollectionKernelInterface;
use WebTheory\Collection\Kernel\CollectionKernel;

trait PoweredByModelCollectionKernelTrait
{
    use PoweredByCollectionKernelTrait;
    use KernelPoweredModelCollectionTrait;

    protected function createKernel(array $models): CollectionKernelInterface
    {
        return new CollectionKernel(
            $models,
            Closure::fromCallable([$this, 'spawn']),
            $this->getKernelArg('MODEL_IDENTIFIER', 'id'),
            $this->getKernelArg('MODEL_PROPERTY_ACCESSORS', []),
            $this->getKernelArg('COLLECTION_IS_MAP', true)
        );
    }
}
