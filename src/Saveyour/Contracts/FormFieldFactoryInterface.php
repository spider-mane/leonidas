<?php

namespace WebTheory\Saveyour\Contracts;

use WebTheory\Saveyour\Contracts\FormFieldInterface;

interface FormFieldFactoryInterface
{
    /**
     *
     */
    public function create(array $args): FormFieldInterface;
}
