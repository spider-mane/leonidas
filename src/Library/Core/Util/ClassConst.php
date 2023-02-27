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
            ? static::value($class, $const)
            : $default;
    }

    public static function required($class, string $const)
    {
        if (static::defined($class, $const)) {
            return static::value($class, $const);
        }

        throw new ErrorException(
            sprintf('%s::%s is not defined', $class, $const)
        );
    }

    public static function defined($class, string $const)
    {
        return (new ReflectionClass($class))->hasConstant($const);
    }

    public static function value($class, string $const)
    {
        return (new ReflectionClassConstant($class, $const))->getValue();
    }
}
