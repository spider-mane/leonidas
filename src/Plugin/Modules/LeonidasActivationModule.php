<?php

namespace Leonidas\Plugin\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\AbstractModule;
use Leonidas\Traits\Hooks\RegistersActivatePluginHook;
use Leonidas\Traits\Hooks\RegistersDeactivatePluginHook;

class LeonidasActivationModule extends AbstractModule implements ModuleInterface
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
        return $this->getExtension()->getBase();
    }

    protected function doActivatePluginAction(bool $networkWide): void
    {
        //
    }

    protected function doDeactivatePluginAction(bool $networkDeactivating): void
    {
        //
    }
}
