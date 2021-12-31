<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsInitHook
{
    protected function targetInitHook()
    {
        add_action(
            'init',
            Closure::fromCallable([$this, 'doInitAction']),
            null,
            PHP_INT_MAX
        );

        return $this;
    }

    abstract protected function doInitAction(): void;
}
