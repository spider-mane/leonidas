<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Post\QueryFactoryInterface;
use Leonidas\Library\System\Model\Post\PostQuery;
use WebTheory\Collection\Comparison\ObjectComparator;
use WP_Query;

class PostQueryFactory implements QueryFactoryInterface
{
    protected ObjectComparator $comparator;

    protected PostConverterInterface $converter;

    protected array $accessors = [];

    public function __construct(PostConverterInterface $converter, ObjectComparator $comparator)
    {
        $this->converter = $converter;
        $this->comparator = $comparator;
    }

    public function createQuery(WP_Query $query): PostQuery
    {
        return new PostQuery($query, $this->converter);
    }
}
