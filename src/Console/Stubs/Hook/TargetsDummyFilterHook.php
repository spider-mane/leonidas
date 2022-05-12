<?php

namespace Leonidas\Console\Stubs\Hook;

use Closure;

trait TargetsDummyFilterHook
{
    protected function targetDummyFilterHook()
    {
        add_filter(
            "dummy_filter",
            Closure::fromCallable([$this, 'filterDummyFilter']),
            $this->getDummyFilterPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getDummyFilterPriority(): int
    {
        return HOOK_DEFAULT_PRIORITY;
    }

    abstract protected function filterDummyFilter();
}
