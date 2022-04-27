<?php

namespace Leonidas\Contracts\System\Model\Author;

interface AuthorRepositoryInterface
{
    public function select(int $id): AuthorInterface;
}
