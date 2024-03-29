<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

use Leonidas\Contracts\Ui\Asset\InlineScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\InlineStyleCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptLoaderInterface;
use Leonidas\Contracts\Ui\Asset\ScriptLocalizationCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptPrinterInterface;
use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleLoaderInterface;
use Leonidas\Contracts\Ui\Asset\StylePrinterInterface;
use Leonidas\Framework\Abstracts\MustBeInitiatedContextuallyTrait;
use Leonidas\Library\Core\Asset\ScriptLoader;
use Leonidas\Library\Core\Asset\ScriptPrinter;
use Leonidas\Library\Core\Asset\StyleLoader;
use Leonidas\Library\Core\Asset\StylePrinter;

trait ProvisionsAssetsTrait
{
    use AbstractModuleTraitTrait;
    use MustBeInitiatedContextuallyTrait;

    protected ScriptLoaderInterface $scriptLoader;

    protected ScriptPrinterInterface $scriptPrinter;

    protected StyleLoaderInterface $styleLoader;

    protected StylePrinterInterface $stylePrinter;

    protected ?ScriptCollectionInterface $scripts = null;

    protected ?StyleCollectionInterface $styles = null;

    protected ?InlineScriptCollectionInterface $inlineScripts = null;

    protected ?InlineStyleCollectionInterface $inlineStyles = null;

    protected ?ScriptLocalizationCollectionInterface $scriptLocalizations = null;

    protected function getScriptLoader(): ScriptLoaderInterface
    {
        return $this->scriptLoader;
    }

    protected function getScriptPrinter(): ScriptPrinterInterface
    {
        return $this->scriptPrinter;
    }

    protected function getStyleLoader(): StyleLoaderInterface
    {
        return $this->styleLoader;
    }

    protected function getStylePrinter(): StylePrinterInterface
    {
        return $this->stylePrinter;
    }

    protected function getScripts(): ?ScriptCollectionInterface
    {
        return $this->scripts;
    }

    protected function getStyles(): ?StyleCollectionInterface
    {
        return $this->styles;
    }

    protected function getInlineScripts(): ?InlineScriptCollectionInterface
    {
        return $this->inlineScripts;
    }

    protected function getInlineStyles(): ?InlineStyleCollectionInterface
    {
        return $this->inlineStyles;
    }

    protected function getScriptLocalizations(): ?ScriptLocalizationCollectionInterface
    {
        return $this->scriptLocalizations;
    }

    protected function hasScripts(): bool
    {
        return ($scripts = $this->getScripts())
            && !empty($scripts->getScripts());
    }

    public function hasStyles(): bool
    {
        return ($styles = $this->getStyles())
            && !empty($styles->getStyles());
    }

    protected function hasInlineScripts(): bool
    {
        return ($inlineScripts = $this->getInlineScripts())
            && !empty($inlineScripts->getScripts());
    }

    public function hasInlineStyles(): bool
    {
        return ($inlineStyles = $this->getInlineStyles())
            && !empty($inlineStyles->getStyles());
    }

    public function hasScriptLocalizations(): bool
    {
        return ($scriptLocalizations = $this->getScriptLocalizations())
            && !empty($scriptLocalizations->getLocalizations());
    }

    protected function assetRegistrationRequiredProperties(): array
    {
        return [
            'scripts',
            'inlineScripts',
            'scriptLocalizations',
            'styles',
            'inlineStyles',
            'scriptLoader',
            'scriptPrinter',
            'styleLoader',
            'stylePrinter',
        ];
    }

    protected function provisionAssets(?string $hookSuffix = null): void
    {
        $this->init('asset_registration');

        $request = $this->getServerRequest();

        $scriptLoader = $this->getScriptLoader();
        $styleLoader = $this->getStyleLoader();

        if ($hookSuffix) {
            $request = $request->withAttribute('hook_suffix', $hookSuffix);
        }

        if ($this->hasScripts()) {
            $scriptLoader->load($this->getScripts(), $request);
        }

        if ($this->hasStyles()) {
            $styleLoader->load($this->getStyles(), $request);
        }

        if ($this->hasInlineScripts()) {
            $scriptLoader->support($this->getInlineScripts(), $request);
        }

        if ($this->hasInlineStyles()) {
            $styleLoader->support($this->getInlineStyles(), $request);
        }

        if ($this->hasScriptLocalizations()) {
            $scriptLoader->localize($this->getScriptLocalizations(), $request);
        }

        $scriptLoader->activate(...$this->activateScripts());
        $scriptLoader->deactivate(...$this->deactivateScripts());

        $styleLoader->activate(...$this->activateStyles());
        $styleLoader->deactivate(...$this->deactivateStyles());
    }

    protected function filterScriptLoaderTag(string $tag, string $handle, string $src): string
    {
        if (!$this->isInitiated() || !$this->hasScripts() || !$this->getScripts()->hasScript($handle)) {
            return $tag;
        }

        return $this->getScriptPrinter()
            ->merge($tag, $this->getScripts()->getScript($handle));
    }

    protected function filterStyleLoaderTag(string $tag, string $handle, string $href, string $media): string
    {
        if (!$this->isInitiated() || !$this->hasStyles() || !$this->getStyles()->hasStyle($handle)) {
            return $tag;
        }

        return $this->getStylePrinter()
            ->merge($tag, $this->getStyles()->getStyle($handle));
    }

    protected function asset(?string $asset = null): string
    {
        return $this->extension->url(
            $this->configCascade($this->assetsConfigCascade()) . $asset
        );
    }

    protected function assetsConfigCascade(): array
    {
        return [
            'view.assets.path', 'view.assets', 'theme.assets',
        ];
    }

    protected function version(?string $version = null): string
    {
        if ($this->extension->isInDev()) {
            return (string) time();
        }

        return $version ?: $this->extension->getVersion();
    }

    protected function scriptLoader(): ScriptLoaderInterface
    {
        return new ScriptLoader();
    }

    protected function scriptPrinter(): ScriptPrinterInterface
    {
        return new ScriptPrinter();
    }

    protected function styleLoader(): StyleLoaderInterface
    {
        return new StyleLoader();
    }

    protected function stylePrinter(): StylePrinterInterface
    {
        return new StylePrinter();
    }

    protected function scripts(): ?ScriptCollectionInterface
    {
        return null;
    }

    protected function styles(): ?StyleCollectionInterface
    {
        return null;
    }

    protected function inlineScripts(): ?InlineScriptCollectionInterface
    {
        return null;
    }

    protected function inlineStyles(): ?InlineStyleCollectionInterface
    {
        return null;
    }

    protected function scriptLocalizations(): ?ScriptLocalizationCollectionInterface
    {
        return null;
    }

    protected function activateScripts(): array
    {
        return [];
    }

    protected function deactivateScripts(): array
    {
        return [];
    }

    protected function activateStyles(): array
    {
        return [];
    }

    protected function deactivateStyles(): array
    {
        return [];
    }
}
