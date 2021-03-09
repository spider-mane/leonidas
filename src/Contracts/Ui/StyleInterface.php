<?php

namespace WebTheory\Leonidas\Contracts\Ui;

use WebTheory\Leonidas\Contracts\Ui\AssetInterface;

interface StyleInterface extends AssetInterface
{
    /**
     * @return string
     */
    public function getMedia(): ?string;
}
