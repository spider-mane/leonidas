<?php

namespace Leonidas\Plugin\Module;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\Abstracts\PluginSetupModule;

final class Setup extends PluginSetupModule implements ModuleInterface
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
