<?php

namespace WebTheory\Saveyour\Contracts;

use WebTheory\Saveyour\Contracts\FormFieldInterface;

interface FieldDataManagerFactoryInterface
{
    /**
     *
     */
    public function create(array $args): FieldDataManagerInterface;
}
