<?php

namespace Leonidas\Framework\Modules\Traits;

use Closure;

trait HasCallbackMethodsTrait
{
    /**
     * Wraps a method in a closure to allow protected methods to be used as
     * callbacks to 3rd party code.
     */
    protected function callbackMethod(string $method): Closure
    {
        return Closure::fromCallable([$this, $method]);
    }
}
