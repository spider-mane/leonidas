<?php

namespace Leonidas\Contracts\System\Model\Tag;

use Leonidas\Contracts\System\Model\SystemModelCollectionInterface;

interface TagCollectionInterface extends SystemModelCollectionInterface
{
    public function getById(int $id): TagInterface;
}
