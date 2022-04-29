<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use WP_Post;

trait HierarchicalPostModelTrait
{
    protected WP_Post $post;

    public function getParentId(): int
    {
        return $this->post->post_parent;
    }
}
