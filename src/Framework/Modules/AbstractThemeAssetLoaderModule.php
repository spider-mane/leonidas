<?php

namespace WebTheory\Leonidas\Framework\Modules;

use WebTheory\Leonidas\Contracts\Extension\ModuleInterface;
use WebTheory\Leonidas\Traits\Hooks\TargetsWpEnqueueScriptsHook;

abstract class AbstractThemeAssetLoaderModule extends AbstractModule implements ModuleInterface
{
    use TargetsWpEnqueueScriptsHook;

    public function hook(): void
    {
        $this->targetWpEnqueueScriptsHook();
    }
}
