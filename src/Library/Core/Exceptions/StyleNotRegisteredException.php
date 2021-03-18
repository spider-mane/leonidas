<?php

namespace Leonidas\Library\Core\Exceptions;

use RuntimeException;

class StyleNotRegisteredException extends RuntimeException
{
    protected $message = "The requested stylesheet \"%s\" has not been registered.";

    public function __construct(string $style)
    {
        parent::__construct(sprintf($this->getMessage(), $style));
    }
}
