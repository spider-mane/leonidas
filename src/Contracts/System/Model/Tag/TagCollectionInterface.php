<?php

namespace Leonidas\Contracts\System\Model\Tag;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface TagCollectionInterface extends ModelCollectionInterface
{
    public function getById(int $id): TagInterface;
}
