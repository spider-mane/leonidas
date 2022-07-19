<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsWpBodyOpenHook
{
    protected function targetWpBodyOpenHook()
    {
        add_action(
            "wp_body_open",
            Closure::fromCallable([$this, 'doWpBodyOpenAction']),
            $this->getWpBodyOpenPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getWpBodyOpenPriority(): int
    {
        return HOOK_DEFAULT_PRIORITY;
    }

    abstract protected function doWpBodyOpenAction(): void;
}
