<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\Traits\ProvisionsAssetsTrait;
use Leonidas\Hooks\TargetsEnqueueBlockEditorAssetsHook;
use Leonidas\Hooks\TargetsScriptLoaderTagHook;
use Leonidas\Hooks\TargetsStyleLoaderTagHook;

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
