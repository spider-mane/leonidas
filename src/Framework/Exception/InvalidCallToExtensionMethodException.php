<?php

namespace Leonidas\Framework\Exception;

use RuntimeException;

abstract class InvalidCallToExtensionMethodException extends RuntimeException
{
    /**
     * {@inheritDoc}
     */
    protected $message = "%s should only be initiated internally. If you're seeing this Exception it's because the user, a plugin, or theme has made an illegal call to the privately designated function, %s";

    public function __construct(string $extension, callable $function)
    {
        parent::__construct(sprintf($this->getMessage(), $extension, $function));
    }
}
