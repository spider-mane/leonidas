<?php

namespace Leonidas\Enum;

use MyCLabs\Enum\Enum;
use UnexpectedValueException;

abstract class BackedEnum extends Enum
{
    public function __get($name)
    {
        if ('value' === $name) {
            return $this->getValue();
        }
    }

    public static function tryFrom($value)
    {
        try {
            return static::from($value);
        } catch (UnexpectedValueException $e) {
            return null;
        }
    }

    public static function cases(): array
    {
        return static::toArray();
    }
}
