<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsAfterSetupThemeHook
{
    protected function targetAfterSetupThemeHook()
    {
        add_action(
            'after_setup_theme',
            Closure::fromCallable([$this, 'doAfterSetupThemeAction']),
            10,
            PHP_INT_MAX
        );
    }

    abstract protected function doAfterSetupThemeAction(): void;
}
