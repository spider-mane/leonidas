<?php

namespace Leonidas\Contracts\System\Model\Author;

use Leonidas\Contracts\System\Model\SystemModelCollectionInterface;

interface AuthorCollectionInterface extends SystemModelCollectionInterface
{
    public function getById(int $id): AuthorInterface;
}
