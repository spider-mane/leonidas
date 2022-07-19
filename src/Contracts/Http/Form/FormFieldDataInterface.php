<?php

namespace Leonidas\Contracts\Http\Form;

interface FormFieldDataInterface
{
    public function name(): string;

    public function value(): ?string;

    public function required(): bool;
}
