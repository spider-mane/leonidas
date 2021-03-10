<?php

namespace Leonidas\Contracts\Ui;

use Leonidas\Contracts\Ui\AssetInterface;

interface StyleInterface extends AssetInterface
{
    /**
     * @return string
     */
    public function getMedia(): ?string;
}
