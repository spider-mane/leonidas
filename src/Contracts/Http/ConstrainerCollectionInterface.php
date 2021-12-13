<?php

namespace Leonidas\Contracts\Http;

use Psr\Http\Message\ServerRequestInterface;

interface ConstrainerCollectionInterface
{
    public function constrains(ServerRequestInterface $request): bool;
}
