<?php

namespace Leonidas\Contracts\System\Model\Author;

use Leonidas\Contracts\System\Model\MutableUserModelInterface;
use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;

interface MutableAuthorInterface extends AuthorInterface, MutableUserModelInterface
{
    public function setPosts(PostCollectionInterface $posts): self;
}
