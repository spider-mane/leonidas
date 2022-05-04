<?php

namespace Leonidas\Library\System\Schema\Exceptions;

use LogicException;

class UnexpectedEntityException extends LogicException
{
    public function __construct(string $expected, object $provided, string $method)
    {
        parent::__construct(
            sprintf(
                'The entity object passed to %s must be instance of %s, %s given',
                $method,
                $expected,
                get_class($provided)
            )
        );
    }
}
