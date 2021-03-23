<?php

namespace Leonidas\Traits\Hooks;

trait TargetsActivatePluginHook
{
    protected function targetActivatePluginHook()
    {
        add_action(
            'activate_plugin',
            $this->getActivatePluginCallback(),
            null,
            PHP_INT_MAX
        );
    }

    protected function getActivatePluginCallback()
    {
        return function (string $plugin, bool $networkWide) {
            $this->doActivatePluginAction($plugin, $networkWide);
        };
    }

    abstract protected function doActivatePluginAction(string $plugin, bool $networkWide): void;
}
