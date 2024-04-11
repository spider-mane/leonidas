<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsAfterSetupThemeHook
{
    protected function targetAfterSetupThemeHook()
    {
        add_action(
            "after_setup_theme",
            Closure::fromCallable([$this, 'doAfterSetupThemeAction']),
            $this->getAfterSetupThemePriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getAfterSetupThemePriority(): int
    {
        return 10;
    }

    abstract protected function doAfterSetupThemeAction(): void;
}
