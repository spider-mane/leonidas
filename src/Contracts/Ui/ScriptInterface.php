<?php

namespace WebTheory\Leonidas\Contracts\Ui;

use WebTheory\Leonidas\Contracts\Ui\AssetInterface;

interface ScriptInterface extends AssetInterface
{
    /**
     * @return bool
     */
    public function loadInFooter(): ?bool;
}
