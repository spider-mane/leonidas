<?php

namespace Leonidas\Traits;

use Closure;

trait HasCallbackMethodsTrait
{
    protected function callback(string $method): Closure
    {
        return Closure::fromCallable([$this, $method]);
    }
}
