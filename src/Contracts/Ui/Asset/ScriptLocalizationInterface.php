<?php

namespace Leonidas\Contracts\Ui\Asset;

use Psr\Http\Message\ServerRequestInterface;

interface ScriptLocalizationInterface
{
    public function getHandle(): string;

    public function getVariable(): string;

    public function getData(): array;

    public function shouldBeLoaded(ServerRequestInterface $request): bool;
}
