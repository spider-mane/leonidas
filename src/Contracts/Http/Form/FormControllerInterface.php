<?php

namespace Leonidas\Contracts\Http\Form;

interface FormControllerInterface
{
    /**
     * @return array
     */
    public function build(): array;
}
