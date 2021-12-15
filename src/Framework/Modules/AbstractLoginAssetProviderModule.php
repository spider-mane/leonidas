<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Traits\Hooks\TargetsLoginEnqueueScriptsHook;
use Leonidas\Traits\Hooks\TargetsScriptLoaderTagHook;
use Leonidas\Traits\Hooks\TargetsStyleLoaderTagHook;
use Leonidas\Traits\ProvisionsAssetsTrait;

abstract class AbstractLoginAssetProviderModule extends AbstractModule implements ModuleInterface
{
    use TargetsLoginEnqueueScriptsHook;
    use TargetsScriptLoaderTagHook;
    use TargetsStyleLoaderTagHook;
    use ProvisionsAssetsTrait;

    /**
     * @var ScriptCollectionInterface
     */
    protected $scripts;

    /**
     * @var StyleCollectionInterface
     */
    protected $styles;

    public function hook(): void
    {
        $this->targetLoginEnqueueScriptsHook();
        $this->targetScriptLoaderTagHook();
        $this->targetStyleLoaderTagHook();
    }

    protected function doLoginEnqueueScriptsAction(): void
    {
        $this->provisionAssets();
    }
}
