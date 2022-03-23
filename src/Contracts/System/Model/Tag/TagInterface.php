<?php

namespace Leonidas\Contracts\System\Model\Tag;

use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Schema\Term\TermInterface;

interface TagInterface extends TermInterface
{
    public function getParent(): ?TagInterface;

    public function getPosts(): PostCollectionInterface;
}
