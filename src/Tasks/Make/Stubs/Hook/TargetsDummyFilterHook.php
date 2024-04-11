<?php

namespace Leonidas\Tasks\Make\Stubs\Hook;

trait TargetsDummyFilterHook
{
    protected function targetDummyFilterHook()
    {
        add_filter(
            "dummy_filter",
            $this->filterDummyFilter(...),
            $this->getDummyFilterPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getDummyFilterPriority(): int
    {
        return 10;
    }

    abstract protected function filterDummyFilter();
}
