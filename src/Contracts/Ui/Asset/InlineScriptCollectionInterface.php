<?php

namespace Leonidas\Contracts\Ui\Asset;

interface InlineScriptCollectionInterface
{
    /**
     * @return InlineScriptInterface[]
     */
    public function getScripts(): array;

    public function getScript(string $script): InlineScriptInterface;

    public function hasScript(string $script): bool;

    public function addScript(InlineScriptInterface $script);
}
