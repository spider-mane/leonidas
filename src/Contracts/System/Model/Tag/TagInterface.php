<?php

namespace Leonidas\Contracts\System\Model\Tag;

use Leonidas\Contracts\System\Model\MutableTermModelInterface;
use Leonidas\Contracts\System\Model\Post\HasManyMutablePostsInterface;
use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;

interface TagInterface extends MutableTermModelInterface, HasManyMutablePostsInterface
{
    public function getDescription(): string;

    public function setDescription(string $description): self;

    // public function getPosts(): PostCollectionInterface;

    // public function setPosts(PostCollectionInterface $posts): self;
}
