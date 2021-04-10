<?php

namespace Leonidas\Contracts\Ui;

interface ScriptInterface extends AssetInterface
{
    /**
     * @return bool
     */
    public function loadInFooter(): ?bool;
}
