<?php

namespace WebTheory\Leonidas\Core\Contracts;

interface StyleInterface extends AssetInterface
{
    /**
     * @return string
     */
    public function getMedia(): ?string;
}
