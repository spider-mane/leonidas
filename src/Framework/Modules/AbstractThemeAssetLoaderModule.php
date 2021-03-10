<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Traits\Hooks\TargetsWpEnqueueScriptsHook;

abstract class AbstractThemeAssetLoaderModule extends AbstractModule implements ModuleInterface
{
    use TargetsWpEnqueueScriptsHook;

    public function hook(): void
    {
        $this->targetWpEnqueueScriptsHook();
    }
}
