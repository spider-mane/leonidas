<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsAfterSetupThemeHook
{
    protected function targetAfterSetupThemeHook()
    {
        add_action(
            'after_setup_theme',
            Closure::fromCallable([$this, 'doAfterSetupThemeAction']),
            null,
            PHP_INT_MAX
        );
    }

    abstract protected function doAfterSetupThemeAction(): void;
}
