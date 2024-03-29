<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Hooks\RegistersActivatePluginHook;
use Leonidas\Hooks\RegistersDeactivatePluginHook;

abstract class PluginSetupModule extends Module implements ModuleInterface
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
