<?php

namespace Leonidas\Contracts\Ui\Asset;

use Psr\Http\Message\ServerRequestInterface;

interface InlineStyleInterface
{
    public function getHandle(): string;

    public function getCode(): string;

    public function shouldBeLoaded(ServerRequestInterface $request): bool;
}
