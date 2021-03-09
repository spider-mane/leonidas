<?php

namespace WebTheory\Leonidas\Framework\Modules;

use WebTheory\Leonidas\Contracts\Extension\ModuleInterface;
use WebTheory\Leonidas\Traits\Hooks\TargetsAdminEnqueueScriptHook;

abstract class AbstractAdminAssetLoaderModule extends AbstractModule implements ModuleInterface
{
    use TargetsAdminEnqueueScriptHook;

    public function hook(): void
    {
        $this->targetAdminEnqueueScriptsHook();
    }
}
