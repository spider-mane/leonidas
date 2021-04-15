<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Traits\Hooks\TargetsAdminEnqueueScriptHook;

abstract class AbstractAdminAssetProvisionModule extends AbstractModule implements ModuleInterface
{
    use TargetsAdminEnqueueScriptHook;

    public function hook(): void
    {
        $this->targetAdminEnqueueScriptsHook();
    }
}
