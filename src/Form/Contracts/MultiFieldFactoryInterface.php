<?php

namespace WebTheory\Form\Contracts;

use WebTheory\Form\Contracts\FormFieldInterface;

interface MultiFieldFactoryInterface
{
    /**
     *
     */
    public function create(string $field, array $args): FormFieldInterface;
}
