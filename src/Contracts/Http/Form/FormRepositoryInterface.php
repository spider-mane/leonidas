<?php

namespace Leonidas\Contracts\Http\Form;

interface FormRepositoryInterface
{
    public function add(FormInterface $form): void;

    public function fetch(string $handle): FormInterface;

    public function mapped(string $action): FormInterface;
}
