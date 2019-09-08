<?php

namespace Backalley\Form\Contracts;

use Backalley\Form\Contracts\FormFieldInterface;

interface FieldDataManagerFactoryInterface
{
    /**
     *
     */
    public function create(array $args): FieldDataManagerInterface;
}
