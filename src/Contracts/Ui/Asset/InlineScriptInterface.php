<?php

namespace Leonidas\Contracts\Ui\Asset;

use Psr\Http\Message\ServerRequestInterface;

interface InlineScriptInterface
{
    public function getHandle(): string;

    public function getData(): string;

    public function getPosition(): string;

    public function shouldBeLoaded(ServerRequestInterface $request): bool;
}
