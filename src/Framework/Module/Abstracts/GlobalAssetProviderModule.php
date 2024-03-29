<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\Ui\Asset\InlineScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\InlineStyleCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptLocalizationCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Framework\Module\Abstracts\Traits\ProvisionsAssetsTrait;
use Leonidas\Hooks\TargetsAdminEnqueueScriptsHook;
use Leonidas\Hooks\TargetsEnqueueBlockEditorAssetsHook;
use Leonidas\Hooks\TargetsLoginEnqueueScriptsHook;
use Leonidas\Hooks\TargetsScriptLoaderTagHook;
use Leonidas\Hooks\TargetsStyleLoaderTagHook;
use Leonidas\Hooks\TargetsWpEnqueueScriptsHook;

abstract class GlobalAssetProviderModule extends Module implements ModuleInterface
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
        // $this->targetScriptLoaderTagHook();
        // $this->targetStyleLoaderTagHook();
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

    protected function scripts(): ?ScriptCollectionInterface
    {
        return $this->getContextAssetsMethod('Scripts')();
    }

    protected function styles(): ?StyleCollectionInterface
    {
        return $this->getContextAssetsMethod('Styles')();
    }

    protected function inlineScripts(): ?InlineScriptCollectionInterface
    {
        return $this->getContextAssetsMethod('InlineScripts')();
    }

    protected function inlineStyles(): ?InlineStyleCollectionInterface
    {
        return $this->getContextAssetsMethod('InlineStyles')();
    }

    protected function scriptLocalizations(): ?ScriptLocalizationCollectionInterface
    {
        return $this->getContextAssetsMethod('ScriptLocalizations')();
    }

    protected function getContextAssetsMethod(string $type): array
    {
        return [$this, static::CONTEXTS[current_action()] . $type];
    }

    protected function adminScripts(): ?ScriptCollectionInterface
    {
        return null;
    }

    protected function adminStyles(): ?StyleCollectionInterface
    {
        return null;
    }

    protected function blockEditorScripts(): ?ScriptCollectionInterface
    {
        return null;
    }

    protected function blockEditorStyles(): ?StyleCollectionInterface
    {
        return null;
    }

    protected function loginScripts(): ?ScriptCollectionInterface
    {
        return null;
    }

    protected function loginStyles(): ?StyleCollectionInterface
    {
        return null;
    }

    protected function publicScripts(): ?ScriptCollectionInterface
    {
        return null;
    }

    protected function publicStyles(): ?StyleCollectionInterface
    {
        return null;
    }

    protected function adminInlineScripts(): ?InlineScriptCollectionInterface
    {
        return null;
    }

    protected function adminInlineStyles(): ?InlineStyleCollectionInterface
    {
        return null;
    }

    protected function blockEditorInlineScripts(): ?InlineScriptCollectionInterface
    {
        return null;
    }

    protected function blockEditorInlineStyles(): ?InlineStyleCollectionInterface
    {
        return null;
    }

    protected function loginInlineScripts(): ?InlineScriptCollectionInterface
    {
        return null;
    }

    protected function loginInlineStyles(): ?InlineStyleCollectionInterface
    {
        return null;
    }

    protected function publicInlineScripts(): ?InlineScriptCollectionInterface
    {
        return null;
    }

    protected function publicInlineStyles(): ?InlineStyleCollectionInterface
    {
        return null;
    }

    protected function adminScriptLocalizations(): ?ScriptLocalizationCollectionInterface
    {
        return null;
    }

    protected function blockEditorScriptLocalizations(): ?ScriptLocalizationCollectionInterface
    {
        return null;
    }

    protected function loginScriptLocalizations(): ?ScriptLocalizationCollectionInterface
    {
        return null;
    }

    protected function publicScriptLocalizations(): ?ScriptLocalizationCollectionInterface
    {
        return null;
    }
}
