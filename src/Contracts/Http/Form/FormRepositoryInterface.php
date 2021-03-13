<?php

namespace Leonidas\Contracts\Http\Form;

interface FormRepositoryInterface
{
    public function register(string $id, FormControllerInterface $form);

    public function getForm(string $id): FormControllerInterface;

    public function build(string $form): array;
}
