<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\Post\AttachmentEntityManagerInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Post\QueryFactoryInterface;
use WP_Query;

class AttachmentEntityQueryManager extends AttachmentEntityManager implements AttachmentEntityManagerInterface
{
    protected QueryFactoryInterface $queryFactory;

    public function __construct(
        string $type,
        PostConverterInterface $postConverter,
        QueryFactoryInterface $queryFactory
    ) {
        $this->type = $type;
        $this->entityConverter = $postConverter;
        $this->queryFactory = $queryFactory;
    }

    public function getCollectionFromQuery(WP_Query $query): object
    {
        return $this->queryFactory->createQuery($query);
    }
}
