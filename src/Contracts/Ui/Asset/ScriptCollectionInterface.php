<?php

namespace Leonidas\Contracts\Ui\Asset;

interface ScriptCollectionInterface
{
    /**
     * @return ScriptInterface[]
     */
    public function getScripts(): array;

    public function getScript(string $script): ScriptInterface;

    public function hasScript(string $script): bool;
}
