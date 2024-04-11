<?php

namespace Leonidas\Library\System\Model\Factory;

use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Post\QueryFactoryInterface;
use WP_Query;

class PostEntityQueryFactory implements QueryFactoryInterface
{
    public function __construct(protected string $class, protected PostConverterInterface $converter)
    {
        //
    }

    public function createQuery(WP_Query $query): object
    {
        return new $this->class($query, $this->converter);
    }
}
