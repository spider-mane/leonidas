<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use WP_Post;

trait FilterablePostModelTrait
{
    protected WP_Post $post;

    public function getFilter(): string
    {
        return $this->post->filter;
    }

    public function applyFilter(string $filter): void
    {
        $this->post->filter($filter);
    }
}
