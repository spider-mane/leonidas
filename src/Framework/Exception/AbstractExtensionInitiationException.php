<?php

namespace Leonidas\Framework\Exception;

use RuntimeException;

abstract class AbstractExtensionInitiationException extends RuntimeException
{
    /**
     * {@inheritDoc}
     */
    protected $message = "%s should only be initiated internally. If you're seeing this Exception it's because the user, a plugin, or theme has made an invalid call to private function: %s";

    public function __construct(string $extension, string $function)
    {
        parent::__construct(sprintf($this->getMessage(), $extension, $function));
    }
}
