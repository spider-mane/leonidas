<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Post\PostEntityManagerInterface;
use WP_Query;

class PostEntityQueryManager extends PostEntityManager implements PostEntityManagerInterface
{
    protected PostQueryFactory $queryFactory;

    public function __construct(
        string $type,
        PostConverterInterface $postConverter,
        PostQueryFactory $queryFactory
    ) {
        $this->type = $type;
        $this->entityConverter = $postConverter;
        $this->queryFactory = $queryFactory;
    }

    public function query(WP_Query $query): object
    {
        $query->set('post_type', $this->type);

        return $this->createQuery($query);
    }

    protected function createQuery(WP_Query $query): object
    {
        return $this->queryFactory->createQuery($query);
    }
}
