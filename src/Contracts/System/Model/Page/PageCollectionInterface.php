<?php

namespace Leonidas\Contracts\System\Model\Page;

use Leonidas\Contracts\System\Model\SystemModelCollectionInterface;

interface PageCollectionInterface extends SystemModelCollectionInterface
{
    public function getById(int $id): PageInterface;
}
