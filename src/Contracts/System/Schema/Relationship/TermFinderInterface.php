<?php

namespace Leonidas\Contracts\System\Schema\Relationship;

interface TermFinderInterface
{
    public function byId(int $id);

    public function byName(string $term);
}
