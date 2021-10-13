<?php

namespace Leonidas\Contracts\Ui\Asset;

interface StyleInterface extends AssetInterface
{
    /**
     * @return string
     */
    public function getMedia(): ?string;

    public function isDisabled(): ?bool;

    public function getHrefLang(): ?string;

    public function getTitle(): ?string;
}
