<?php

namespace Leonidas\Library\System\Model\Post;

use Countable;
use IteratorAggregate;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Schema\Post\PostQueryArrayObject;
use Traversable;
use WP_Query;

class PostQuery implements IteratorAggregate, Countable
{
    protected PostQueryArrayObject $query;

    public function __construct(WP_Query $query, PostConverterInterface $converter)
    {
        $this->query = new PostQueryArrayObject($query, $converter);
    }

    public function count(): int
    {
        return $this->query->count();
    }

    public function getIterator(): Traversable
    {
        return $this->query;
    }
}
