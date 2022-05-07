<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsInitHook
{
    protected function targetInitHook()
    {
        add_action(
            'init',
            Closure::fromCallable([$this, 'doInitAction']),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    abstract protected function doInitAction(): void;
}
