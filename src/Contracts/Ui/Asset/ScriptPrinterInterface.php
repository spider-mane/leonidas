<?php

namespace Leonidas\Contracts\Ui\Asset;

interface ScriptPrinterInterface
{
    public function print(ScriptInterface $script): string;

    public function merge(string $html, ScriptInterface $script): string;
}
