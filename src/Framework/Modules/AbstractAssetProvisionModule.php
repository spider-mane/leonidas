<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Traits\Hooks\TargetsScriptLoaderTagHook;
use Leonidas\Traits\Hooks\TargetsStyleLoaderTagHook;
use Leonidas\Traits\Hooks\TargetsWpEnqueueScriptsHook;
use Leonidas\Traits\ProvisionsAssetsTrait;

abstract class AbstractAssetProvisionModule extends AbstractModule implements ModuleInterface
{
    use ProvisionsAssetsTrait;
    use TargetsScriptLoaderTagHook;
    use TargetsStyleLoaderTagHook;
    use TargetsWpEnqueueScriptsHook;

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
        $this->targetWpEnqueueScriptsHook();
        $this->targetScriptLoaderTagHook();
        $this->targetStyleLoaderTagHook();
    }

    public function doWpEnqueueScriptAction(string $hookSuffix)
    {
        $this->provisionAssets($hookSuffix);
    }
}
