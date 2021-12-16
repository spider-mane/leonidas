<?php

namespace Leonidas\Contracts\Ui\Asset;

use Psr\Http\Message\ServerRequestInterface;

interface InlineStyleInterface
{
    public function getHandle(): string;

    public function getData(): string;

    public function shouldBeLoaded(ServerRequestInterface $request): bool;
}
