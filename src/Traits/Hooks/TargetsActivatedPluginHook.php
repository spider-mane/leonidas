<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsActivatedPluginHook
{
    protected function targetActivatedPluginHook()
    {
        add_action(
            'activated_plugin',
            $this->getActivatedPluginCallback(),
            null,
            PHP_INT_MAX
        );
    }

    protected function getActivatedPluginCallback(): Closure
    {
        return function (string $plugin, bool $networkWide) {
            $this->doActivatedPluginAction($plugin, $networkWide);
        };
    }

    abstract protected function doActivatedPluginAction(string $plugin, bool $networkWide): void;
}
