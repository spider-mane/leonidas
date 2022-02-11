<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsShutdownHook
{
    protected function targetShutdownHook()
    {
        add_action(
            "shutdown",
            Closure::fromCallable([$this, 'doShutdownAction']),
            $this->getShutdownPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getShutdownPriority(): int
    {
        return 10;
    }

    abstract protected function doShutdownAction(): void;
}
