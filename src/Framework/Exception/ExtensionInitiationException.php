<?php

namespace Leonidas\Framework\Exception;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use RuntimeException;

class ExtensionInitiationException extends RuntimeException
{
    /**
     * {@inheritDoc}
     */
    protected $message = "%s should only be initiated internally. If you're seeing this error it's because the user, a plugin, or theme has made an invalid call to private function: %s";

    public function __construct(WpExtensionInterface $extension, string $function)
    {
        parent::__construct(sprintf(
            $this->getMessage(),
            $extension->getName(),
            $function
        ));
    }
}
