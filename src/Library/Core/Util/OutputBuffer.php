<?php

namespace Leonidas\Library\Core\Util;

class OutputBuffer
{
    public static function wrap(callable $callback): string
    {
        ob_start();

        $callback();

        return ob_get_clean();
    }

    public static function call(callable $function, ...$args): string
    {
        return static::wrap(fn () => $function(...$args));
    }

    public static function require(string $file, array $data): string
    {
        return static::wrap(fn () => require $file);
    }

    public static function requireOnce(string $file, array $data): string
    {
        return static::wrap(fn () => require_once $file);
    }

    public static function include(string $file, array $data): string
    {
        return static::wrap(fn () => include $file);
    }

    public static function includeOnce(string $file, array $data): string
    {
        return static::wrap(fn () => include_once $file);
    }
}
