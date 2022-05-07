<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\Traits\ProvisionsAssetsTrait;
use Leonidas\Traits\Hooks\TargetsAdminEnqueueScriptsHook;
use Leonidas\Traits\Hooks\TargetsScriptLoaderTagHook;
use Leonidas\Traits\Hooks\TargetsStyleLoaderTagHook;

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
