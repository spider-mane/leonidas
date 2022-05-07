<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

trait HierarchicalPostModelTrait
{
    use MappedToWpPostTrait;

    public function getParentId(): int
    {
        return $this->post->post_parent;
    }
}
