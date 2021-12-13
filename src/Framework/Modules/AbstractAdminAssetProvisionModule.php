<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Traits\Hooks\TargetsAdminEnqueueScriptsHook;
use Leonidas\Traits\Hooks\TargetsScriptLoaderTagHook;
use Leonidas\Traits\Hooks\TargetsStyleLoaderTagHook;
use Leonidas\Traits\ProvisionsAssetsTrait;

abstract class AbstractAdminAssetProvisionModule extends AbstractModule implements ModuleInterface
{
    use TargetsScriptLoaderTagHook;
    use TargetsStyleLoaderTagHook;
    use TargetsAdminEnqueueScriptsHook;
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
        $this->targetAdminEnqueueScriptsHook();
        $this->targetScriptLoaderTagHook();
        $this->targetStyleLoaderTagHook();
    }

    protected function doAdminEnqueueScriptsAction(string $hookSuffix): void
    {
        $this->provisionAssets($hookSuffix);
    }
}
