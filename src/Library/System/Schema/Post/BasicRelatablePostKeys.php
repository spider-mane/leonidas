<?php

namespace Leonidas\Library\System\Schema\Post;

use Leonidas\Contracts\System\Schema\Post\RelatablePostKeyInterface;

class BasicRelatablePostKeys implements RelatablePostKeyInterface
{
    protected const SUFFIX = '_id';

    public function getPostKey(string $postType): string
    {
        return $postType . static::SUFFIX;
    }
}
