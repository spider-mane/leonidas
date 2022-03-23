<?php

namespace Leonidas\Contracts\System\Model\Category;

use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Schema\Term\TermInterface;

interface CategoryInterface extends TermInterface
{
    public function getParent(): ?CategoryInterface;

    public function getPosts(): PostCollectionInterface;
}
