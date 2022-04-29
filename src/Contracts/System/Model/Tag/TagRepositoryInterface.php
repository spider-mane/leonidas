<?php

namespace Leonidas\Contracts\System\Model\Tag;

use Leonidas\Library\System\Model\Tag\TagCollection;

interface TagRepositoryInterface
{
    public function select(int $id): TagInterface;

    public function whereObjectId(int $objectId): TagCollection;
}
