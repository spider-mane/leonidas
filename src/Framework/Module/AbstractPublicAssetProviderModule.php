<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\Abstracts\ProvisionsAssetsTrait;
use Leonidas\Hooks\TargetsScriptLoaderTagHook;
use Leonidas\Hooks\TargetsStyleLoaderTagHook;
use Leonidas\Hooks\TargetsWpEnqueueScriptsHook;

abstract class AbstractPublicAssetProviderModule extends AbstractModule implements ModuleInterface
{
    use TargetsWpEnqueueScriptsHook;
    use TargetsScriptLoaderTagHook;
    use TargetsStyleLoaderTagHook;
    use ProvisionsAssetsTrait;

    public function hook(): void
    {
        $this->targetWpEnqueueScriptsHook();
        // $this->targetScriptLoaderTagHook();
        // $this->targetStyleLoaderTagHook();
    }

    public function doWpEnqueueScriptsAction(): void
    {
        $this->provisionAssets();
    }
}
