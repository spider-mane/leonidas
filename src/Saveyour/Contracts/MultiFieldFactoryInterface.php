<?php

namespace WebTheory\Saveyour\Contracts;

use WebTheory\Saveyour\Contracts\FormFieldInterface;

interface MultiFieldFactoryInterface
{
    /**
     *
     */
    public function create(string $field, array $args): FormFieldInterface;
}
