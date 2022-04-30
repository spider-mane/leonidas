<?php

namespace Leonidas\Contracts\System\Model\Category;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface CategoryCollectionInterface extends ModelCollectionInterface
{
    public function extractIds(): array;

    public function extractNames(): array;
}
