<?php

namespace Leonidas\Library\Core\Util;

use ErrorException;
use ReflectionClass;
use ReflectionClassConstant;

class ClassConst
{
    public static function optional($class, string $const, $default)
    {
        return static::defined($class, $const)
            ? static::constant($class, $const)
            : $default;
    }

    public static function required($class, string $const)
    {
        if (static::defined($class, $const)) {
            return static::constant($class, $const);
        }

        throw new ErrorException(
            sprintf('%s::%s is not defined', $class, $const)
        );
    }

    public static function defined($class, string $const)
    {
        return (new ReflectionClass($class))->hasConstant($const);
    }

    public static function constant($class, string $const)
    {
        return (new ReflectionClassConstant($class, $const))->getValue();
    }
}
