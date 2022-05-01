<?php

namespace Leonidas\Library\System\Model\Page;

use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Post\QueryFactoryInterface;
use WP_Query;

class PageQueryFactory implements QueryFactoryInterface
{
    protected PostConverterInterface $converter;

    public function __construct(PostConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    public function createQuery(WP_Query $query): PageQuery
    {
        return new PageQuery($query, $this->converter);
    }
}
