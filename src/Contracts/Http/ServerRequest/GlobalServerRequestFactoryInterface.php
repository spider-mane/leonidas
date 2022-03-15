<?php

namespace Leonidas\Contracts\Http\ServerRequest;

use Psr\Http\Message\ServerRequestInterface;

interface GlobalServerRequestFactoryInterface
{
    public function create(): ServerRequestInterface;
}
