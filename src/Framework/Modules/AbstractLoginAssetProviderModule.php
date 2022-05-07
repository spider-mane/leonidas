<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\Traits\ProvisionsAssetsTrait;
use Leonidas\Hooks\TargetsLoginEnqueueScriptsHook;
use Leonidas\Hooks\TargetsScriptLoaderTagHook;
use Leonidas\Hooks\TargetsStyleLoaderTagHook;

abstract class AbstractLoginAssetProviderModule extends AbstractModule implements ModuleInterface
{
    use TargetsLoginEnqueueScriptsHook;
    use TargetsScriptLoaderTagHook;
    use TargetsStyleLoaderTagHook;
    use ProvisionsAssetsTrait;

    public function hook(): void
    {
        $this->targetLoginEnqueueScriptsHook();
        // $this->targetScriptLoaderTagHook();
        // $this->targetStyleLoaderTagHook();
    }

    protected function doLoginEnqueueScriptsAction(): void
    {
        $this->provisionAssets();
    }
}
