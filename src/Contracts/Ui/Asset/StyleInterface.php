<?php

namespace Leonidas\Contracts\Ui\Asset;

interface StyleInterface extends AssetInterface
{
    public function getMedia(): ?string;

    public function isDisabled(): ?bool;

    public function getHrefLang(): ?string;

    public function getTitle(): ?string;

    // public function getInlineSupport(): ?InlineStyleCollectionInterface;

    // public function hasInlineSupport(): bool;
}
