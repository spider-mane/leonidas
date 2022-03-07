<?php

namespace Leonidas\Traits\Hooks;

use Closure;
use WP_Screen;

trait TargetsCurrentScreenHook
{
    protected function targetCurrentScreenHook()
    {
        add_action(
            "current_screen",
            Closure::fromCallable([$this, 'doCurrentScreenAction']),
            $this->getCurrentScreenPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getCurrentScreenPriority(): int
    {
        return HOOK_DEFAULT_PRIORITY;
    }

    abstract protected function doCurrentScreenAction(WP_Screen $screen): void;
}
