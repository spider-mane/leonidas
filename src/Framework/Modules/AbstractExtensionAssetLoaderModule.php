<?php

namespace WebTheory\Leonidas\Framework\Modules;

use WebTheory\Leonidas\Admin\Contracts\ModuleInterface;
use WebTheory\Leonidas\Framework\Traits\Hooks\TargetsAdminEnqueueScriptHook;
use WebTheory\Leonidas\Framework\Traits\Hooks\TargetsWpEnqueueScriptsHook;

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
