<?php

namespace Leonidas\Library\Core\Util;

use Closure;

class OutputBuffer
{
    public static function call(callable $function, ...$args): string
    {
        ob_start();

        $function(...$args);

        return ob_get_clean();
    }

    public static function wrap(callable $function): Closure
    {
        return fn () => static::call($function, ...func_get_args());
    }

    public static function require(string $file, ?array $data = null): string
    {
        return static::call(function () use ($file, $data) {
            if (!isset($data)) {
                unset($data);
            }

            require $file;
        });
    }

    public static function requireOnce(string $file, ?array $data = null): string
    {
        return static::call(function () use ($file, $data) {
            if (!isset($data)) {
                unset($data);
            }

            require_once $file;
        });
    }

    public static function include(string $file, ?array $data = null): string
    {
        return static::call(function () use ($file, $data) {
            if (!isset($data)) {
                unset($data);
            }

            include $file;
        });
    }

    public static function includeOnce(string $file, ?array $data = null): string
    {
        return static::call(function () use ($file, $data) {
            if (!isset($data)) {
                unset($data);
            }

            include_once $file;
        });
    }
}
