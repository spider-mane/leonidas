<?php

namespace WebTheory\Leonidas\Framework\Exceptions;

use RuntimeException;
use WebTheory\Leonidas\Admin\Contracts\ModuleInterface;

class InvalidModuleException extends RuntimeException
{
    protected $interface = ModuleInterface::class;

    public function __construct(string $module)
    {
        "{$module} does not implement {$this->interface} interface.";
    }
}