<?php

namespace Leonidas\Library\Core\Exceptions;

use RuntimeException;

class MissedHookException extends RuntimeException
{
    /**
     * @var string
     */
    protected $message = 'The "%s" hook has already run.';

    public function __construct(string $tag)
    {
        parent::__construct(sprintf($this->getMessage(), $tag));
    }
}
