<?php

namespace Leonidas\Contracts\Ui\Asset;

interface ScriptRepositoryInterface
{
    public function getScripts(): array;

    public function addScript(ScriptInterface $script);
}
