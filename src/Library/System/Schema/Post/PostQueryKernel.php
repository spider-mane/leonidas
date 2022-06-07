<?php

namespace Leonidas\Library\System\Schema\Post;

use Closure;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Schema\Post\Abstracts\ManagesPostConversionsTrait;
use Traversable;
use WebTheory\Collection\Contracts\CollectionKernelInterface;
use WebTheory\Collection\Contracts\JsonSerializerInterface;
use WebTheory\Collection\Contracts\ObjectComparatorInterface;
use WebTheory\Collection\Contracts\OperationProviderInterface;
use WebTheory\Collection\Json\BasicJsonSerializer;
use WebTheory\Collection\Kernel\CollectionKernel;
use WebTheory\Collection\Query\Operation\Operations;
use WebTheory\Collection\Resolution\PropertyResolver;
use WP_Query;

class PostQueryKernel extends CollectionKernel implements CollectionKernelInterface
{
    use ManagesPostConversionsTrait;

    protected WP_Query $query;

    public function __construct(
        WP_Query $query,
        PostConverterInterface $converter,
        ObjectComparatorInterface $comparator,
        Closure $generator,
        array $accessors = [],
        ?JsonSerializerInterface $jsonSerializer = null,
        ?OperationProviderInterface $operationProvider = null
    ) {
        $this->query = $query;
        $this->items = &$query->posts;
        $this->generator = $generator;
        $this->converter = $converter;

        $this->jsonSerializer = $jsonSerializer ?? new BasicJsonSerializer();
        $this->operationProvider = $operationProvider ?? new Operations();

        $this->archive = new PostConversionArchive();
        $this->propertyResolver = new PropertyResolver($accessors);

        $this->driver = new PostQueryDriver(
            $query,
            $converter,
            $comparator,
            $this->archive,
        );
    }

    public function values(): array
    {
        return array_values($this->toArray());
    }

    public function toArray(): array
    {
        return array_map([$this, 'getConvertedPost'], $this->items);
    }

    public function getIterator(): Traversable
    {
        return new PostQueryIterator(
            $this->query,
            $this->converter,
            $this->archive
        );
    }

    public function first(): object
    {
        return $this->getConvertedPost(parent::first());
    }

    public function last(): object
    {
        return $this->getConvertedPost(parent::last());
    }

    public function count(): int
    {
        return $this->query->post_count;
    }

    protected function spawnWith(CollectionKernel $clone): object
    {
        /** @var self $clone */
        $clone->query = clone $this->query;
        $clone->query->posts = $clone->items;
        $clone->query->post_count = $clone->count();
        $clone->items = &$clone->query->posts;

        return parent::spawnWith($clone);
    }

    protected function spawnFrom(array $items): object
    {
        $clone = clone $this;

        $clone->items = $items;

        return $this->spawnWith($clone);
    }
}
