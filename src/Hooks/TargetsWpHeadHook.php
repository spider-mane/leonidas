<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsWpHeadHook
{
    protected function targetWpHeadHook()
    {
        add_action(
            "wp_head",
            Closure::fromCallable([$this, 'doWpHeadAction']),
            $this->getWpHeadPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getWpHeadPriority(): int
    {
        return 10;
    }

    abstract protected function doWpHeadAction(): void;
}
