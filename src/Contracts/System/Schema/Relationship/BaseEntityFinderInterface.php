<?php

namespace Leonidas\Contracts\System\Schema\Relationship;

use Leonidas\Contracts\System\Model\Post\PostInterface;

interface BaseEntityFinderInterface
{
    public function byId(int $id): PostInterface;

    public function byName(string $post): PostInterface;
}
