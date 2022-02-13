<?php

namespace Leonidas\Contracts\Http\Form;

use Psr\Http\Message\ServerRequestInterface;

interface FormControllerInterface extends FormHandlerInterface
{
    public function getAction(): string;

    public function process(ServerRequestInterface $request): void;
}
