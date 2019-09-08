<?php

namespace Backalley\Form\Contracts;

use Backalley\Form\Contracts\FormFieldInterface;

interface FormFieldFactoryInterface
{
    /**
     *
     */
    public function create(array $args): FormFieldInterface;
}
