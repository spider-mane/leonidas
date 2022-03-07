<?php

namespace Leonidas\Contracts\Resource;

interface ResourceLocatorInterface
{
    public function get(string $key, $default = null);
}
