<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Traits\Hooks\TargetsAdminEnqueueScriptHook;
use Leonidas\Traits\Hooks\TargetsWpEnqueueScriptsHook;

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
