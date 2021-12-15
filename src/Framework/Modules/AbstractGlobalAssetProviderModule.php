<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptInterface;
use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleInterface;
use Leonidas\Framework\Modules\AbstractModule;
use Leonidas\Library\Core\Asset\ScriptCollection;
use Leonidas\Library\Core\Asset\StyleCollection;
use Leonidas\Traits\Hooks\TargetsAdminEnqueueScriptsHook;
use Leonidas\Traits\Hooks\TargetsEnqueueBlockEditorAssetsHook;
use Leonidas\Traits\Hooks\TargetsLoginEnqueueScriptsHook;
use Leonidas\Traits\Hooks\TargetsScriptLoaderTagHook;
use Leonidas\Traits\Hooks\TargetsStyleLoaderTagHook;
use Leonidas\Traits\Hooks\TargetsWpEnqueueScriptsHook;
use Leonidas\Traits\ProvisionsAssetsTrait;

abstract class AbstractGlobalAssetProviderModule extends AbstractModule implements ModuleInterface
{
    use TargetsEnqueueBlockEditorAssetsHook;
    use TargetsAdminEnqueueScriptsHook;
    use TargetsLoginEnqueueScriptsHook;
    use TargetsWpEnqueueScriptsHook;
    use TargetsScriptLoaderTagHook;
    use TargetsStyleLoaderTagHook;
    use ProvisionsAssetsTrait;

    protected const CONTEXTS = [
        'admin_enqueue_scripts' => 'admin',
        'enqueue_block_editor_assets' => 'blockEditor',
        'login_enqueue_scripts' => 'login',
        'wp_enqueue_scripts' => 'public',
    ];

    public function hook(): void
    {
        $this->targetEnqueueBlockEditorAssetsHook();
        $this->targetAdminEnqueueScriptsHook();
        $this->targetLoginEnqueueScriptsHook();
        $this->targetWpEnqueueScriptsHook();
        $this->targetScriptLoaderTagHook();
        $this->targetStyleLoaderTagHook();
    }

    protected function doAdminEnqueueScriptsAction(string $hookSuffix): void
    {
        $this->provisionAssets($hookSuffix);
    }

    protected function doEnqueueBlockEditorAssetsAction(): void
    {
        $this->provisionAssets();
    }

    protected function doLoginEnqueueScriptsAction(): void
    {
        $this->provisionAssets();
    }

    protected function doWpEnqueueScriptsAction(): void
    {
        $this->provisionAssets();
    }

    protected function scripts(): ScriptCollectionInterface
    {
        return $this->getContextAssetsMethod('Scripts')();
    }

    protected function styles(): StyleCollectionInterface
    {
        return $this->getContextAssetsMethod('Styles')();
    }

    protected function getContextAssetsMethod(string $type): array
    {
        return [$this, static::CONTEXTS[current_action()] . $type];
    }

    protected function adminScripts(): ScriptCollectionInterface
    {
        return new ScriptCollection();
    }

    protected function adminStyles(): StyleCollectionInterface
    {
        return new StyleCollection();
    }

    protected function blockEditorScripts(): ScriptCollectionInterface
    {
        return new ScriptCollection();
    }

    protected function blockEditorStyles(): StyleCollectionInterface
    {
        return new StyleCollection();
    }

    protected function loginScripts(): ScriptCollectionInterface
    {
        return new ScriptCollection();
    }

    protected function loginStyles(): StyleCollectionInterface
    {
        return new StyleCollection();
    }

    protected function publicScripts(): ScriptCollectionInterface
    {
        return new ScriptCollection();
    }

    protected function publicStyles(): StyleCollectionInterface
    {
        return new StyleCollection();
    }
}
