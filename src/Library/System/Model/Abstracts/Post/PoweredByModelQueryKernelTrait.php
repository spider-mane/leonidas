<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use Closure;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\Core\Util\ClassConst;
use Leonidas\Library\System\Model\Abstracts\KernelPoweredModelCollectionTrait;
use Leonidas\Library\System\Schema\Post\PostQueryKernel;
use WebTheory\Collection\Comparison\ObjectComparator;
use WebTheory\Collection\Contracts\CollectionKernelInterface;
use WP_Query;

trait PoweredByModelQueryKernelTrait
{
    use KernelPoweredModelCollectionTrait;

    protected function initKernel(WP_Query $query, PostConverterInterface $converter): void
    {
        $this->kernel = $this->createKernel($query, $converter);
    }

    protected function createKernel(WP_Query $query, PostConverterInterface $converter): CollectionKernelInterface
    {
        return new PostQueryKernel(
            $query,
            $converter,
            new ObjectComparator(),
            Closure::fromCallable([$this, 'spawn']),
            ClassConst::optional($this, 'MODEL_PROPERTY_ACCESSORS', [])
        );
    }
}
