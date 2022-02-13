<?php

namespace Leonidas\Contracts\Http\Form;

interface FormDataInterface
{
    public function method(): string;

    public function action(): string;

    public function checks(): array;

    public function fields(): array;
}
