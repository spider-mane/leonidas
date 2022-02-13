<?php

namespace Leonidas\Contracts\Http\Form;

use Psr\Http\Message\ServerRequestInterface;

interface FormHandlerInterface
{
    public function getBuild(ServerRequestInterface $request): array;
}
