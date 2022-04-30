<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Library\System\Model\Abstracts\Post\AbstractPostModelQuery;
use Leonidas\Library\System\Model\Post\Abstracts\PostCollectionTrait;
use WP_Query;

class PostQuery extends AbstractPostModelQuery implements PostCollectionInterface
{
    use PostCollectionTrait;

    public function __construct(WP_Query $query, PostConverterInterface $converter)
    {
        parent::__construct($query, $converter);
    }
}
