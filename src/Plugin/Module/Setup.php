<?php

namespace Leonidas\Plugin\Module;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\AbstractPluginSetupModule;

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
