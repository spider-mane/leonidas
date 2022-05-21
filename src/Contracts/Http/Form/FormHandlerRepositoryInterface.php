<?php

namespace Leonidas\Contracts\Http\Form;

use Psr\Http\Message\ServerRequestInterface;

interface FormHandlerRepositoryInterface
{
    public function add(FormHandlerInterface $form);

    public function get(string $handle): FormHandlerInterface;

    public function getBuild(string $handle, ServerRequestInterface $request): array;
}
