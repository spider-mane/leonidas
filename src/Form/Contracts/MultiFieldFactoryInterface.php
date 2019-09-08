<?php

namespace Backalley\Form\Contracts;

use Backalley\Form\Contracts\FormFieldInterface;

interface MultiFieldFactoryInterface
{
    /**
     *
     */
    public function create(string $field, array $args): FormFieldInterface;
}
