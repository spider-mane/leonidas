<?php

namespace Leonidas\Framework\Exceptions;

use Leonidas\Contracts\Extension\ModuleInterface;
use RuntimeException;

class InvalidModuleException extends RuntimeException
{
    protected $interface = ModuleInterface::class;

    public function __construct(string $module)
    {
        $message = "\"{$module}\" does not implement \"{$this->interface}\" interface.";

        parent::__construct($message);
    }
}
