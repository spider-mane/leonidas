<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsWpLoadedHook
{
    protected function targetWpLoadedHook()
    {
        add_action(
            "wp_loaded",
            Closure::fromCallable([$this, 'doWpLoadedAction']),
            $this->getWpLoadedPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getWpLoadedPriority(): int
    {
        return 10;
    }

    abstract protected function doWpLoadedAction(): void;
}
