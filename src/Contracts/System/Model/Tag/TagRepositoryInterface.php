<?php

namespace Leonidas\Contracts\System\Model\Tag;

interface TagRepositoryInterface
{
    public function select(int $id): TagInterface;
}
