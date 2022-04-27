<?php

namespace Leonidas\Contracts\System\Model\Category;

use Leonidas\Contracts\System\Model\SystemModelCollectionInterface;

interface CategoryCollectionInterface extends SystemModelCollectionInterface
{
    public function extractIds(): array;

    public function extractNames(): array;
}
