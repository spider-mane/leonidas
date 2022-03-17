<?php

namespace Leonidas\Contracts\System\Model\Post;

interface PostCollectionInterface
{
    /**
     * @return PostInterface[]
     */
    public function all(): array;
}
