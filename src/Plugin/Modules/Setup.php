<?php

namespace Leonidas\Plugin\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\AbstractModule;
use Leonidas\Framework\Modules\AbstractPluginSetupModule;
use Leonidas\Traits\Hooks\RegistersActivatePluginHook;
use Leonidas\Traits\Hooks\RegistersDeactivatePluginHook;

final class Setup extends AbstractPluginSetupModule implements ModuleInterface
{
    protected function doActivatePluginAction(bool $networkWide): void
    {
        //
    }

    protected function doDeactivatePluginAction(bool $networkDeactivating): void
    {
        //
    }
}
