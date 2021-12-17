<?php

namespace Leonidas\Contracts\Ui\Asset;

interface ScriptLocalizationCollectionInterface
{
    /**
     * @return ScriptLocalizationInterface[]
     */
    public function getLocalizations(): array;

    public function getLocalization(string $variable): ScriptLocalizationInterface;

    public function hasLocalization(string $variable): bool;
}
