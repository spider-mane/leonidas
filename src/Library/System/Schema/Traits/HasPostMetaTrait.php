<?php

namespace Leonidas\Library\System\Schema\Traits;

trait HasPostMetaTrait
{
    protected function getPostMeta(string $key, bool $single = true)
    {
        return get_post_meta($this->getId(), $key, $single);
    }

    abstract protected function getId(): int;
}
