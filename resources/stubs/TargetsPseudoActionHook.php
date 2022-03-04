<?php

use Closure;

trait TargetsPseudoActionTypeHook
{
    protected function targetPseudoActionHook()
    {
        add_action(
            "pseudo_action",
            Closure::fromCallable([$this, 'doPseudoActionAction']),
            $this->getPseudoActionPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getPseudoActionPriority(): int
    {
        return HOOK_DEFAULT_PRIORITY;
    }

    abstract protected function doPseudoActionAction(): void;
}
