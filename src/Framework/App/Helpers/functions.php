<?php

use Env\Env;

if (!function_exists('env')) {
    function env(string $name, $default = null)
    {
        return Env::get($name) ?? $default;
    }
}
