<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Traits\Hooks\TargetsAdminEnqueueScriptsHook;
use Leonidas\Traits\Hooks\TargetsWpEnqueueScriptsHook;

abstract class AbstractExtensionAssetProvisionModule extends AbstractModule implements ModuleInterface
{
    use TargetsWpEnqueueScriptsHook;
    use TargetsAdminEnqueueScriptsHook;

    public function hook(): void
    {
        $this->targetWpEnqueueScriptsHook();
        $this->targetAdminEnqueueScriptsHook();
    }
}
