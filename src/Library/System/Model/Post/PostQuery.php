<?php

namespace Leonidas\Library\System\Model\Post;

use IteratorAggregate;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Schema\Post\PostQueryArrayObject;
use Traversable;
use WP_Query;

class PostQuery implements IteratorAggregate
{
    protected WP_Query $query;

    protected PostQueryArrayObject $array;

    public function __construct(WP_Query $query, ?PostConverterInterface $converter = null)
    {
        $this->query = $query;
        $this->array = new PostQueryArrayObject(
            $query,
            $converter ?? new ViewPostConverter()
        );
    }

    public function getIterator(): Traversable
    {
        return $this->array;
    }
}
