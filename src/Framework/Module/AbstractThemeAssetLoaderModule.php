<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Hooks\TargetsWpEnqueueScriptsHook;

abstract class AbstractThemeAssetLoaderModule extends AbstractModule implements ModuleInterface
{
    use TargetsWpEnqueueScriptsHook;

    public function hook(): void
    {
        $this->targetWpEnqueueScriptsHook();
    }
}
