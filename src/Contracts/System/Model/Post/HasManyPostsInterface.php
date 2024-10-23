<?php

namespace Leonidas\Contracts\System\Model\Post;

interface HasManyPostsInterface
{
    public function getPosts(): PostCollectionInterface;
}
