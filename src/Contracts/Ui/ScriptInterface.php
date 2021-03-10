<?php

namespace Leonidas\Contracts\Ui;

use Leonidas\Contracts\Ui\AssetInterface;

interface ScriptInterface extends AssetInterface
{
    /**
     * @return bool
     */
    public function loadInFooter(): ?bool;
}
