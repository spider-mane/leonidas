<?php

namespace Leonidas\Contracts\Ui\Asset;

interface ScriptInterface extends AssetInterface
{
    public function shouldLoadInFooter(): ?bool;

    public function isAsync(): ?bool;

    public function isDeferred(): ?bool;

    public function getIntegrity(): ?string;

    public function isNoModule(): ?bool;

    public function getNonce(): ?string;

    public function getReferrerPolicy(): ?string;

    public function getType(): ?string;

    // public function getLocalizations(): ?ScriptLocalizationCollectionInterface;

    // public function hasLocalizations(): bool;

    // public function getInlineSupport(): ?InlineScriptCollectionInterface;

    // public function hasInlineSupport(): bool;
}
