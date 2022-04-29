<?php

namespace Leonidas\Contracts\System\Model;

interface FilterableInterface
{
    public function getFilter(): string;

    public function applyFilter(string $filter): void;
}
