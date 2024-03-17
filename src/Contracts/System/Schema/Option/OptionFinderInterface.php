<?php

namespace Leonidas\Contracts\System\Schema\Option;

interface OptionFinderInterface
{
    public function find(string $option): string;
}
