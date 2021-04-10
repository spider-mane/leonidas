<?php

namespace Leonidas\Contracts\Ui;

interface StyleInterface extends AssetInterface
{
    /**
     * @return string
     */
    public function getMedia(): ?string;
}
