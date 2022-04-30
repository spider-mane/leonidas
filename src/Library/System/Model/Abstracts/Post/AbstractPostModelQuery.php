<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use Closure;
use IteratorAggregate;
use Leonidas\Contracts\System\Model\SystemModelCollectionInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Model\Abstracts\PoweredByKernelTrait;
use Leonidas\Library\System\Schema\Post\PostQueryKernel;
use WebTheory\Collection\Comparison\ObjectComparator;
use WebTheory\Collection\Contracts\ObjectComparatorInterface;
use WP_Query;

abstract class AbstractPostModelQuery implements SystemModelCollectionInterface, IteratorAggregate
{
    use PoweredByKernelTrait;

    protected const MODEL_PROPERTY_ACCESSORS = [];

    protected function __construct(
        WP_Query $query,
        PostConverterInterface $converter,
        ObjectComparatorInterface $comparator = null
    ) {
        $this->kernel = new PostQueryKernel(
            $query,
            $converter,
            $comparator ?? new ObjectComparator(),
            Closure::fromCallable([$this, 'spawn']),
            static::MODEL_PROPERTY_ACCESSORS
        );
    }
}
