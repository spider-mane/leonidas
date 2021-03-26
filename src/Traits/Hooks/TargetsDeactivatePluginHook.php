<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsDeactivatePluginHook
{
    protected function targetDeactivatePluginHook()
    {
        add_action(
            'deactivate_plugin',
            $this->getDeactivatePluginCallback(),
            null,
            PHP_INT_MAX
        );
    }

    protected function getDeactivatePluginCallback(): Closure
    {
        return function (string $plugin, bool $networkWide) {
            $this->doDeactivatePluginAction($plugin, $networkWide);
        };
    }

    abstract protected function doDeactivatePluginAction(string $plugin, bool $networkWide): void;
}
