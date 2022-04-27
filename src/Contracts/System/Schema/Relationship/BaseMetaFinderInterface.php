<?php

namespace Leonidas\Contracts\System\Schema\Relationship;

interface BaseMetaFinderInterface
{
    /**
     * @return mixed
     */
    public function get(string $key, bool $single);
}
