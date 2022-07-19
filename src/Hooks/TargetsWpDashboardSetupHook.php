<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsWpDashboardSetupHook
{
    protected function targetWpDashboardSetupHook()
    {
        add_action(
            "wp_dashboard_setup",
            Closure::fromCallable([$this, 'doWpDashboardSetupAction']),
            $this->getWpDashboardSetupPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getWpDashboardSetupPriority(): int
    {
        return HOOK_DEFAULT_PRIORITY;
    }

    abstract protected function doWpDashboardSetupAction(): void;
}
