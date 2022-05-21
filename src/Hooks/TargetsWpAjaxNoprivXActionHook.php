<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsWpAjaxNoprivXActionHook
{
    protected function targetWpAjaxNoprivXActionHook()
    {
        add_action(
            "wp_ajax_nopriv_{$this->getAction()}",
            Closure::fromCallable([$this, 'doWpAjaxNoprivXActionAction']),
            $this->getWpAjaxNoprivXActionPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getWpAjaxNoprivXActionPriority(): int
    {
        return HOOK_DEFAULT_PRIORITY;
    }

    abstract protected function getAction(): string;

    abstract protected function doWpAjaxNoprivXActionAction(): void;
}
