<?php

namespace Leonidas\Contracts\Ui\Asset;

interface ScriptLocalizationInterface
{
    public function getHandle(): string;

    public function getVariable(): string;

    public function getData(): array;
}
