<?php

namespace Leonidas\Traits;

use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\ScriptLoaderInterface;
use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleLoaderInterface;
use Leonidas\Library\Core\Asset\ScriptLoader;
use Leonidas\Library\Core\Asset\StyleLoader;
use Psr\Http\Message\ServerRequestInterface;

trait ProvisionsAssetsTrait
{
    protected function getScriptCollection(): ?ScriptCollectionInterface
    {
        return $this->scripts;
    }

    protected function getStyleCollection(): ?StyleCollectionInterface
    {
        return $this->styles;
    }

    protected function getScriptLoader(): ScriptLoaderInterface
    {
        return $this->scriptsLoader;
    }

    protected function getStyleLoader(): StyleLoaderInterface
    {
        return $this->stylesLoader;
    }

    protected function init()
    {
        $this->scripts = $this->scripts();
        $this->styles = $this->styles();
        $this->scriptLoader = new ScriptLoader($this->getScriptCollection());
        $this->styleLoader = new StyleLoader($this->getStyleCollection());
    }

    protected function hasScripts(): bool
    {
        return !empty($this->getScriptCollection());
    }

    public function hasStyles(): bool
    {
        return !empty($this->getStyleCollection());
    }

    protected function provisionAssets(?string $hookSuffix = null): void
    {
        $this->init();

        if ($this->hasScripts()) {
            $this->getScriptLoader()->load($this->getServerRequest());
        }

        if ($this->hasStyles()) {
            $this->getStyleLoader()->load($this->getServerRequest());
        }
    }

    protected function filterScriptLoaderTag(string $tag, string $handle, string $src): string
    {
        if (!$this->hasScripts() || !$this->getScriptCollection()->hasScript($handle)) {
            return $tag;
        }

        return $this->getScriptLoader()->createScriptTag($this->getScriptCollection()->getScript($handle));
    }

    protected function filterStyleLoaderTag(string $tag, string $handle, string $href, string $media): string
    {
        if (!$this->hasStyles() || !$this->getStyleCollection()->hasStyle($handle)) {
            return $tag;
        }

        return $this->getStyleLoader()->createStyleTag($handle);
    }

    protected function asset(?string $asset = null)
    {
        return $this->extension->asset($asset);
    }

    protected function vot(?string $version = null)
    {
        return $this->extension->vot($version);
    }

    protected function scripts(): ?ScriptCollectionInterface
    {
        return null;
    }

    protected function styles(): ?StyleCollectionInterface
    {
        return null;
    }

    abstract protected function getServerRequest(): ServerRequestInterface;
}
