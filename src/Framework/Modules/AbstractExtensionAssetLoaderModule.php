<?php

namespace WebTheory\Leonidas\Framework\Modules;

use WebTheory\Leonidas\Contracts\Extension\ModuleInterface;
use WebTheory\Leonidas\Traits\Hooks\TargetsAdminEnqueueScriptHook;
use WebTheory\Leonidas\Traits\Hooks\TargetsWpEnqueueScriptsHook;

abstract class AbstractExtensionAssetLoaderModule extends AbstractModule implements ModuleInterface
{
    use TargetsWpEnqueueScriptsHook;
    use TargetsAdminEnqueueScriptHook;

    public function hook(): void
    {
        $this->targetWpEnqueueScriptsHook();
        $this->targetAdminEnqueueScriptsHook();
    }
}
