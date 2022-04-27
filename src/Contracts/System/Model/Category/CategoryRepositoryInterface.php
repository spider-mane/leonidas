<?php

namespace Leonidas\Contracts\System\Model\Category;

interface CategoryRepositoryInterface
{
    public function select(int $id): CategoryInterface;
}
