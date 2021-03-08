<?php

namespace WebTheory\Leonidas\Core\Contracts;

interface ScriptInterface extends AssetInterface
{
    /**
     * @return bool
     */
    public function loadInFooter(): ?bool;
}
