<?php

namespace WebTheory\Form\Contracts;

use WebTheory\Form\Contracts\FormFieldInterface;

interface FieldDataManagerFactoryInterface
{
    /**
     *
     */
    public function create(array $args): FieldDataManagerInterface;
}
