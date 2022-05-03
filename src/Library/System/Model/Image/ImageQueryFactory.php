<?php

namespace Leonidas\Library\System\Model\Image;

use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\System\Schema\Post\QueryFactoryInterface;
use WP_Query;

class ImageQueryFactory implements QueryFactoryInterface
{
    protected PostConverterInterface $converter;

    public function __construct(PostConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    public function createQuery(WP_Query $query): ImageQuery
    {
        return new ImageQuery($query, $this->converter);
    }
}
