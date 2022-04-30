<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Post\QueryFactoryInterface;
use WP_Query;

class PostQueryFactory implements QueryFactoryInterface
{
    protected PostConverterInterface $converter;

    public function __construct(PostConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    public function createQuery(WP_Query $query): PostQuery
    {
        return new PostQuery($query, $this->converter);
    }
}
