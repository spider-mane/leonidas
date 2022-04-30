<?php

namespace Leonidas\Library\System\Schema\Post;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Traversable;
use WP_Query;

class PostQueryArrayObject implements IteratorAggregate, ArrayAccess, Countable
{
    protected PostQueryAccessor $accessor;

    protected PostQueryIterator $iterator;

    public function __construct(WP_Query $query, PostConverterInterface $converter)
    {
        $archive = new PostConversionArchive();

        $this->accessor = new PostQueryAccessor($query, $converter, $archive);
        $this->iterator = new PostQueryIterator($query, $converter, $archive);
    }

    public function getIterator(): Traversable
    {
        return $this->iterator;
    }

    public function offsetExists($offset): bool
    {
        return $this->accessor->offsetExists($offset);
    }

    public function offsetGet($offset): mixed
    {
        return $this->accessor->offsetGet($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->offsetSet($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->offsetUnset($offset);
    }

    public function count(): int
    {
        return $this->accessor->count();
    }
}
