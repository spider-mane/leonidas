<?php

namespace WebTheory\Form\Contracts;

use WebTheory\Form\Contracts\FieldDataManagerInterface;

interface MultiFieldDataManagerFactoryInterface
{
    /**
     *
     */
    public function create(string $manager, array $args): FieldDataManagerInterface;
}
