<?php

namespace Leonidas\Library\Admin\Callback\Abstracts;

use Closure;
use UnexpectedValueException;

class AbstractCallbackCallbackProvider
{
    public function __construct(protected string|array|Closure $callback)
    {
        if (!is_callable($callback)) {
            throw new UnexpectedValueException(
                "Value of \"\$callback\" must be callable"
            );
        }
    }
}
