<?php

namespace Leonidas\Contracts\Http\Form;

interface FormDataInterface
{
    public function method(): string;

    public function action(): string;

    public function checks(): string;

    public function fields(): array;

    public function errors(): array;

    public function alerts(): array;

    public function output(): ?string;
}
