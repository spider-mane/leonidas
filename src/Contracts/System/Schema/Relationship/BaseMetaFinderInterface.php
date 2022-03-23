<?php

namespace Leonidas\Contracts\System\Schema\Relationship;

interface BaseMetaFinderInterface
{
    public function get(string $key, bool $single);
}
