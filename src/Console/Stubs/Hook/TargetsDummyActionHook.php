<?php

namespace Leonidas\Console\Stubs\Hook;

use Closure;

trait TargetsDummyActionHook
{
    protected function targetDummyActionHook()
    {
        add_action(
            "dummy_action",
            Closure::fromCallable([$this, 'doDummyActionAction']),
            $this->getDummyActionPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getDummyActionPriority(): int
    {
        return HOOK_DEFAULT_PRIORITY;
    }

    abstract protected function doDummyActionAction(): void;
}
