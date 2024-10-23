<?php

namespace Leonidas\Contracts\System\Schema;

interface RelatedEntityFinderInterface
{
    public function hasOne(array $query): array;

    public function hasMany(array $query): array;

    public function forOne(array $query): array;

    public function forMany(array $query): array;
}
