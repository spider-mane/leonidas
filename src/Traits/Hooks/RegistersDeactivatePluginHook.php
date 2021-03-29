<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait RegistersDeactivatePluginHook
{
    protected function registerDeactivationHook()
    {
        register_deactivation_hook(
            $this->getPlugin(),
            $this->getDeactivatePluginCallback()
        );

        return $this;
    }

    protected function getDeactivatePluginCallback(): Closure
    {
        return function (bool $networkDeactivating) {
            $this->doDeactivatePluginAction($networkDeactivating);
        };
    }

    abstract protected function doDeactivatePluginAction(bool $networkDeactivating): void;

    abstract protected function getPlugin(): string;
}
