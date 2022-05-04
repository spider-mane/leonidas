<?php

namespace Leonidas\Contracts\System\Model\Author;

use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\UserModelInterface;

interface AuthorInterface extends UserModelInterface
{
    public function getPosts(): PostCollectionInterface;
}
