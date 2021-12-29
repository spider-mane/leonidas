<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Traits\Hooks\TargetsEnqueueBlockEditorAssetsHook;
use Leonidas\Traits\Hooks\TargetsScriptLoaderTagHook;
use Leonidas\Traits\Hooks\TargetsStyleLoaderTagHook;
use Leonidas\Traits\ProvisionsAssetsTrait;

abstract class AbstractBlockEditorAssetProviderModule extends AbstractModule implements ModuleInterface
{
    use TargetsEnqueueBlockEditorAssetsHook;
    use TargetsScriptLoaderTagHook;
    use TargetsStyleLoaderTagHook;
    use ProvisionsAssetsTrait;

    public function hook(): void
    {
        $this->targetEnqueueBlockEditorAssetsHook();
        // $this->targetScriptLoaderTagHook();
        // $this->targetStyleLoaderTagHook();
    }

    protected function doAdminEnqueueScriptsAction(): void
    {
        $this->provisionAssets();
    }
}
