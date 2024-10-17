<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use WP_Post;

trait MappedToWpPostTrait
{
    protected WP_Post $post;

    protected function getPostModelMeta(string $key)
    {
        return $this->post->{$key};
    }

    protected function setPostModelMeta(string $key, string $value): void
    {
        $this->post->{$key} = $value;
    }

    protected function mirror(string $local, mixed $localVal, string $mapped, mixed $mappedVal): void
    {
        $this->{$local} = $localVal;
        $this->post->{$mapped} = $mappedVal;
    }
}
