<?php

namespace WebTheory\Form\Contracts;

use WebTheory\Form\Contracts\FormFieldInterface;

interface FormFieldFactoryInterface
{
    /**
     *
     */
    public function create(array $args): FormFieldInterface;
}
