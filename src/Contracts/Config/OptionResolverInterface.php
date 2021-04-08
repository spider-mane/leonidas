<?php

namespace Leonidas\Contracts\Config;

interface OptionResolverInterface
{
    public function get(string $option, $default = null);

    public function has(string $option): bool;
}
