<?php

namespace Leonidas\Library\Core\Exception;

use RuntimeException;

class ScriptNotRegisteredException extends RuntimeException
{
    protected $message = "The requested script \"%s\" has not been registered.";

    public function __construct(string $script)
    {
        parent::__construct(sprintf($this->getMessage(), $script));
    }
}
