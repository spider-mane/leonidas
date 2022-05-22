<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\Abstracts\ProvisionsAssetsTrait;
use Leonidas\Hooks\TargetsAdminEnqueueScriptsHook;
use Leonidas\Hooks\TargetsScriptLoaderTagHook;
use Leonidas\Hooks\TargetsStyleLoaderTagHook;

abstract class AbstractAdminAssetProviderModule extends AbstractModule implements ModuleInterface
{
    use TargetsAdminEnqueueScriptsHook;
    use TargetsScriptLoaderTagHook;
    use TargetsStyleLoaderTagHook;
    use ProvisionsAssetsTrait;

    public function hook(): void
    {
        $this->targetAdminEnqueueScriptsHook();
        // $this->targetScriptLoaderTagHook();
        // $this->targetStyleLoaderTagHook();
    }

    protected function doAdminEnqueueScriptsAction(string $hookSuffix): void
    {
        $this->provisionAssets($hookSuffix);
    }
}
