<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsPseudoFilterHook
{
    protected function targetPseudoFilterHook()
    {
        add_action(
            "pseudo_filter",
            Closure::fromCallable([$this, 'filterPseudoFilter']),
            $this->getPseudoFilterPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getPseudoFilterPriority(): int
    {
        return 10;
    }

    abstract protected function filterPseudoFilter(): mixed;
}
