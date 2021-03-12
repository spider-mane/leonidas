<?php

namespace Leonidas\Plugin\Exceptions;

use RuntimeException;

class LeonidasAlreadyLoadedException extends RuntimeException
{
    /**
     * {@inheritDoc}
     */
    protected $message = 'Leonidas should only be initiated internally. If you\'re seeing this Exception it\'s because the user, a plugin, or theme has made an illegal call to "%s"';

    public function __construct(string $method)
    {
        parent::__construct(sprintf($this->getMessage(), $method));
    }
}
