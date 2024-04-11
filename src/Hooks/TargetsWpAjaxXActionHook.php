<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsWpAjaxXActionHook
{
    protected function targetWpAjaxXActionHook()
    {
        add_action(
            "wp_ajax_{$this->getAction()}",
            Closure::fromCallable([$this, 'doWpAjaxXActionAction']),
            $this->getWpAjaxXActionPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getWpAjaxXActionPriority(): int
    {
        return 10;
    }

    abstract protected function getAction(): string;

    abstract protected function doWpAjaxXActionAction(): void;
}
