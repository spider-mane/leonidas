<?php

namespace Leonidas\Contracts\System\Model\Post;

interface HasManyMutablePostsInterface extends HasManyPostsInterface
{
    public function setPosts(PostCollectionInterface $posts): self;
}
