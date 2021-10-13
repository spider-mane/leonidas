<?php

namespace Leonidas\Traits;

use Leonidas\Contracts\Ui\Asset\ScriptCollectionInterface;
use Leonidas\Contracts\Ui\Asset\StyleCollectionInterface;
use Leonidas\Library\Core\Asset\ScriptLoader;
use Leonidas\Library\Core\Asset\StyleLoader;
use Psr\Http\Message\ServerRequestFactoryInterface;

trait ProvisionsAssetsTrait
{
    protected function provisionAssets(?string $hookSuffix = null): void
    {
        $this->init();

        if (isset($this->scripts)) {
            $scriptLoader = new ScriptLoader($this->scripts);
            $scriptLoader->enqueue();
        }

        if (isset($this->styles)) {
            $styleLoader = new StyleLoader($this->styles);
            $styleLoader->enqueue();
        }
    }

    protected function init()
    {
        $this->scripts = $this->getScriptsToProvision();
        $this->styles = $this->getStylesToProvision();
    }

    protected function getScriptsToProvision(): ?ScriptCollectionInterface
    {
        return null;
    }

    protected function getStylesToProvision(): ?StyleCollectionInterface
    {
        return null;
    }

    protected function filterScriptLoaderTag(string $tag, string $handle, string $src): string
    {
        if (!$this->scripts->hasScript($handle)) {
            return $tag;
        }

        return $this->scripts->getScript($handle)->toHtml();
    }

    protected function filterStyleLoaderTag(string $tag, string $handle, string $href, string $media): string
    {
        if (!$this->styles->hasStyle($handle)) {
            return $tag;
        }

        return $this->styles->getStyle($handle)->toHtml();
    }
}
