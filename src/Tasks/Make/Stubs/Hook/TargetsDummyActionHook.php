<?php

namespace Leonidas\Tasks\Make\Stubs\Hook;

trait TargetsDummyActionHook
{
    protected function targetDummyActionHook()
    {
        add_action(
            "dummy_action",
            $this->doDummyActionAction(...),
            $this->getDummyActionPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getDummyActionPriority(): int
    {
        return 10;
    }

    abstract protected function doDummyActionAction(): void;
}
