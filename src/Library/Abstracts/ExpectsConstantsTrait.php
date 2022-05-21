<?php

namespace Leonidas\Library\Abstracts;

use ErrorException;

trait ExpectsConstantsTrait
{
    protected function getOptConstVal(string $const, $default)
    {
        $const = $this->getClassConstantAsString($const);

        return defined($const) ? constant($const) : $default;
    }

    protected function getReqConstVal(string $const)
    {
        $const = $this->getClassConstantAsString($const);

        if (defined($const)) {
            return constant($const);
        }

        throw new ErrorException(
            sprintf('%s::%s is not defined', static::class, $const)
        );
    }

    protected function getClassConstantAsString(string $const)
    {
        return static::class . '::' . $const;
    }
}
