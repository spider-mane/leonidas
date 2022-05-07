<?php

namespace Leonidas\Contracts\System\Model\Author;

use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;

interface AuthorInterface extends UserInterface
{
    public function getPosts(): PostCollectionInterface;
}
