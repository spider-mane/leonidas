<?php

namespace Leonidas\Contracts\Http\Form;

use Psr\Http\Message\ServerRequestInterface;

interface FormHandlerInterface
{
    public function getHandle(): string;

    public function build(ServerRequestInterface $request): array;
}
