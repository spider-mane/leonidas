<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\Post\RelatablePostKeyInterface;

class RelatablePostKeys implements RelatablePostKeyInterface
{
    public function __construct(protected string $prefix = 'post:')
    {
        //
    }

    public function getPostTypeKey(string $postType): string
    {
        return $this->prefix . $postType;
    }

    public function getPostKey(string $postType): string
    {
        return $this->getPostTypeKey($postType) . '_id';
    }
}
