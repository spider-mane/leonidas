<?php

namespace Leonidas\Traits;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Contracts\Ui\Asset\InlineScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\InlineStyleCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptLoaderInterface;
use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleLoaderInterface;
use Leonidas\Library\Core\Asset\InlineScriptCollection;
use Leonidas\Library\Core\Asset\InlineStyleCollection;
use Leonidas\Library\Core\Asset\ScriptCollection;
use Leonidas\Library\Core\Asset\ScriptLoader;
use Leonidas\Library\Core\Asset\StyleCollection;
use Leonidas\Library\Core\Asset\StyleLoader;
use Psr\Http\Message\ServerRequestInterface;

trait ProvisionsAssetsTrait
{
    protected WpExtensionInterface $extension;

    protected ScriptCollectionInterface $scripts;

    protected StyleCollectionInterface $styles;

    protected InlineScriptCollectionInterface $inlineScripts;

    protected InlineStyleCollectionInterface $inlineStyles;

    protected function getScriptCollection(): ScriptCollectionInterface
    {
        return $this->scripts;
    }

    protected function getStyleCollection(): StyleCollectionInterface
    {
        return $this->styles;
    }

    protected function getInlineScriptCollection(): InlineScriptCollectionInterface
    {
        return $this->inlineScripts;
    }

    protected function getInlineStyleColleccion(): InlineStyleCollectionInterface
    {
        return $this->inlineStyles;
    }

    protected function getScriptLoader(): ScriptLoaderInterface
    {
        return $this->scriptLoader;
    }

    protected function getStyleLoader(): StyleLoaderInterface
    {
        return $this->styleLoader;
    }

    protected function init()
    {
        $this->scripts = $this->scripts();
        $this->styles = $this->styles();
        $this->inlineScripts = $this->inlineScripts();
        $this->inlineStyles = $this->inlineStyles();

        $this->scriptLoader = new ScriptLoader($this->getScriptCollection(), $this->getInlineScriptCollection());
        $this->styleLoader = new StyleLoader($this->getStyleCollection(), $this->getInlineStyleColleccion());
    }

    protected function hasScripts(): bool
    {
        return !empty($this->getScriptCollection()->getScripts());
    }

    public function hasStyles(): bool
    {
        return !empty($this->getStyleCollection()->getStyles());
    }

    protected function hasInlineScripts(): bool
    {
        return !empty($this->getInlineScriptCollection()->getScripts());
    }

    public function hasInlineStyles(): bool
    {
        return !empty($this->getInlineStyleCollection()->getStyles());
    }

    protected function provisionAssets(?string $hookSuffix = null): void
    {
        $this->init();

        $request = $this->getServerRequest();

        if ($hookSuffix) {
            $request = $request->withAttribute('hook_suffix', $hookSuffix);
        }

        if ($this->hasScripts()) {
            $this->getScriptLoader()->load($request);
        }

        if ($this->hasStyles()) {
            $this->getStyleLoader()->load($request);
        }

        if ($this->hasInlineScripts()) {
            $this->getScriptLoader()->loadInline($request);
        }

        if ($this->hasInlineStyles()) {
            $this->getStyleLoader()->loadInline($request);
        }
    }

    protected function filterScriptLoaderTag(string $tag, string $handle, string $src): string
    {
        if (!$this->hasScripts() || !$this->getScriptCollection()->hasScript($handle)) {
            return $tag;
        }

        return $this->getScriptLoader()->mergeScriptTag(
            $tag,
            $this->getScriptCollection()->getScript($handle)
        );
    }

    protected function filterStyleLoaderTag(string $tag, string $handle, string $href, string $media): string
    {
        if (!$this->hasStyles() || !$this->getStyleCollection()->hasStyle($handle)) {
            return $tag;
        }

        return $this->getStyleLoader()->mergeStyleTag(
            $tag,
            $this->getStyleCollection()->getStyle($handle)
        );
    }

    protected function asset(?string $asset = null): string
    {
        return $this->extension->asset($asset);
    }

    protected function version(?string $version = null): string
    {
        if ($this->extension->isInDev()) {
            return time();
        }

        return $version ?? $this->extension->getVersion();
    }

    protected function scripts(): ScriptCollectionInterface
    {
        return new ScriptCollection();
    }

    protected function styles(): StyleCollectionInterface
    {
        return new StyleCollection();
    }

    protected function inlineScripts(): InlineScriptCollectionInterface
    {
        return new InlineScriptCollection();
    }

    protected function inlineStyles(): InlineStyleCollectionInterface
    {
        return new InlineStyleCollection();
    }

    abstract protected function getServerRequest(): ServerRequestInterface;
}
