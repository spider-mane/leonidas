<?php

namespace Leonidas\Contracts\Ui\Asset;

use Leonidas\Contracts\Ui\Asset\ScriptInterface;

interface ScriptRepositoryInterface
{
    public function getScripts(): array;

    public function addScript(ScriptInterface $script);
}
