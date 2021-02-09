<?php

namespace WebTheory\Leonidas\Core\Exceptions;

use Exception;

class MissedHookException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'The specified hook has already been executed.';
}
