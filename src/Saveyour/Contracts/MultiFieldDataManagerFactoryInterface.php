<?php

namespace WebTheory\Saveyour\Contracts;

use WebTheory\Saveyour\Contracts\FieldDataManagerInterface;

interface MultiFieldDataManagerFactoryInterface
{
    /**
     *
     */
    public function create(string $manager, array $args): FieldDataManagerInterface;
}
