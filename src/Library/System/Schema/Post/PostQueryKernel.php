<?php

namespace Leonidas\Library\System\Schema\Post;

use Closure;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Schema\Post\Abstracts\ManagesPostConversionsTrait;
use Traversable;
use WebTheory\Collection\Comparison\CollectionComparator;
use WebTheory\Collection\Contracts\ArrayDriverInterface;
use WebTheory\Collection\Contracts\CollectionKernelInterface;
use WebTheory\Collection\Contracts\JsonSerializerInterface;
use WebTheory\Collection\Contracts\ObjectComparatorInterface;
use WebTheory\Collection\Contracts\OperationProviderInterface;
use WebTheory\Collection\Fusion\Collection\FusionSelection;
use WebTheory\Collection\Fusion\Contrast;
use WebTheory\Collection\Fusion\Diff;
use WebTheory\Collection\Fusion\Intersection;
use WebTheory\Collection\Fusion\Merger;
use WebTheory\Collection\Json\BasicJsonSerializer;
use WebTheory\Collection\Kernel\CollectionKernel;
use WebTheory\Collection\Query\Operation\Operations;
use WebTheory\Collection\Resolution\PropertyResolver;
use WP_Query;

class PostQueryKernel extends CollectionKernel implements CollectionKernelInterface
{
    use ManagesPostConversionsTrait;

    protected WP_Query $query;

    protected ObjectComparatorInterface $objectComparator;

    public function __construct(
        WP_Query $query,
        PostConverterInterface $converter,
        ObjectComparatorInterface $objectComparator,
        Closure $generator,
        array $accessors = [],
        ?JsonSerializerInterface $jsonSerializer = null,
        ?OperationProviderInterface $operationProvider = null
    ) {
        $this->query = $query;
        $this->generator = $generator;
        $this->converter = $converter;
        $this->objectComparator = $objectComparator;

        $this->conversionArchive = new PostConversionArchive();
        $this->propertyResolver = new PropertyResolver($accessors);
        $this->collectionComparator = new CollectionComparator($objectComparator);

        $this->jsonSerializer = $jsonSerializer ?? new BasicJsonSerializer();
        $this->operationProvider = $operationProvider ?? new Operations();

        $this->driver = $this->createQueryDriver($query);

        $this->fusions = new FusionSelection([
            'contrast' => new Contrast($objectComparator),
            'diff' => new Diff($objectComparator),
            'intersect' => new Intersection($objectComparator),
            'merge' => new Merger(),
        ]);

        $this->items = $this->convertPosts(...$query->posts);
    }

    public function __debugInfo()
    {
        return [
            'post' => $this->query->post,
            'posts' => $this->query->posts,
            'post_count' => $this->query->post_count,
        ];
    }

    public function count(): int
    {
        return $this->query->post_count;
    }

    public function getIterator(): Traversable
    {
        return new PostQueryIterator(
            $this->query,
            $this->converter,
            $this->conversionArchive
        );
    }

    protected function createQueryDriver(WP_Query $query): ArrayDriverInterface
    {
        return new PostQueryDriver(
            $query,
            $this->converter,
            $this->objectComparator,
            $this->conversionArchive,
        );
    }

    protected function spawnFrom(array $items): object
    {
        $clone = clone $this;

        $clone->query = clone $this->query;
        $clone->query->posts = [];
        $clone->query->post_count = 0;

        $clone->driver = $this->createQueryDriver($clone->query);

        $clone->items = [];
        $clone->collect($items);

        $clone->query->post = reset($clone->query->posts);
        $clone->query->current_post = -1;

        return $this->spawnWith($clone);
    }
}
