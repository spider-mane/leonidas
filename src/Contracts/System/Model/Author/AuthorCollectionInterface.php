<?php

namespace Leonidas\Contracts\System\Model\Author;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface AuthorCollectionInterface extends ModelCollectionInterface
{
    public function getById(int $id): AuthorInterface;
}
