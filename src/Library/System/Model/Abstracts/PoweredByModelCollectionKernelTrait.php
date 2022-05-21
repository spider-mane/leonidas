<?php

namespace Leonidas\Library\System\Model\Abstracts;

use Closure;
use Leonidas\Library\Core\Abstracts\PoweredByCollectionKernelTrait;
use Leonidas\Library\Core\Util\ClassConst;
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
            ClassConst::optional($this, 'MODEL_IDENTIFIER', 'id'),
            ClassConst::optional($this, 'MODEL_PROPERTY_ACCESSORS', []),
            ClassConst::optional($this, 'COLLECTION_IS_MAP', true)
        );
    }
}
