<?php

namespace Leonidas\Library\System\Schema\Traits;

trait HasTermMetaTrait
{
    protected function getPostMeta(string $key, bool $single = true)
    {
        return get_term_meta($this->getId(), $key, $single);
    }

    abstract protected function getId(): int;
}
