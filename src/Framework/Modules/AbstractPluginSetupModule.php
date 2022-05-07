<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Hooks\RegistersActivatePluginHook;
use Leonidas\Hooks\RegistersDeactivatePluginHook;

abstract class AbstractPluginSetupModule extends AbstractModule
{
    use RegistersActivatePluginHook;
    use RegistersDeactivatePluginHook;

    public function hook(): void
    {
        $this->registerActivationHook();
        $this->registerDeactivationHook();
    }

    protected function getPlugin(): string
    {
        return $this->getExtension()->getName();
    }
}
