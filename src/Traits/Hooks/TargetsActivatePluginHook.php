<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsActivatePluginHook
{
    protected function targetActivatePluginHook()
    {
        add_action(
            'activate_plugin',
            $this->getActivatePluginCallback(),
            10,
            PHP_INT_MAX
        );
    }

    protected function getActivatePluginCallback(): Closure
    {
        return function (string $plugin, bool $networkWide) {
            $this->doActivatePluginAction($plugin, $networkWide);
        };
    }

    abstract protected function doActivatePluginAction(string $plugin, bool $networkWide): void;
}
