<?php

namespace WebTheory\Leonidas\Contracts\Form;

interface FormControllerInterface
{
    /**
     * @return array
     */
    public function build(): array;
}
