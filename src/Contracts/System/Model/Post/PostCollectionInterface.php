<?php

namespace Leonidas\Contracts\System\Model\Post;

use Traversable;

interface PostCollectionInterface extends Traversable
{
    /**
     * @return PostInterface[]
     */
    public function all(): array;
}
