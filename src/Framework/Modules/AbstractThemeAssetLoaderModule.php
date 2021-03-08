<?php

namespace WebTheory\Leonidas\Framework\Modules;

use WebTheory\Leonidas\Admin\Contracts\ModuleInterface;
use WebTheory\Leonidas\Framework\Traits\Hooks\TargetsWpEnqueueScriptsHook;

abstract class AbstractThemeAssetLoaderModule extends AbstractModule implements ModuleInterface
{
    use TargetsWpEnqueueScriptsHook;

    public function hook(): void
    {
        $this->targetWpEnqueueScriptsHook();
    }
}
