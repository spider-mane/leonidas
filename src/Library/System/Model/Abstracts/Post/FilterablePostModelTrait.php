<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

trait FilterablePostModelTrait
{
    use MappedToWpPostTrait;

    public function getFilter(): string
    {
        return $this->post->filter;
    }

    public function applyFilter(string $filter): void
    {
        $this->post->filter($filter);
    }
}
