<?php

namespace Backalley\Form\Contracts;

use Backalley\Form\Contracts\FieldDataManagerInterface;

interface MultiFieldDataManagerFactoryInterface
{
    /**
     *
     */
    public function create(string $manager, array $args): FieldDataManagerInterface;
}
