<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Traits\Hooks\TargetsScriptLoaderTagHook;
use Leonidas\Traits\Hooks\TargetsStyleLoaderTagHook;
use Leonidas\Traits\Hooks\TargetsWpEnqueueScriptsHook;
use Leonidas\Traits\ProvisionsAssetsTrait;

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
