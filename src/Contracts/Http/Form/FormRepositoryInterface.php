<?php

namespace Leonidas\Contracts\Http\Form;

use Psr\Http\Message\ServerRequestInterface;

interface FormRepositoryInterface
{
    public function add(string $id, FormHandlerInterface $form);

    public function get(string $id): FormHandlerInterface;

    public function getBuild(string $form, ServerRequestInterface $request): array;
}
