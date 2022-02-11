<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsPseudoActionHook
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
        return 10;
    }

    abstract protected function doPseudoActionAction(): void;
}
