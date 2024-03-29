<?php

namespace Leonidas\Hooks;

use Closure;

trait RegistersActivatePluginHook
{
    protected function registerActivationHook()
    {
        register_activation_hook(
            $this->getPlugin(),
            $this->getActivatePluginCallback()
        );

        return $this;
    }

    protected function getActivatePluginCallback(): Closure
    {
        return function (bool $networkWide) {
            $this->doActivatePluginAction($networkWide);
        };
    }

    abstract protected function doActivatePluginAction(bool $networkWide): void;

    abstract protected function getPlugin(): string;
}
