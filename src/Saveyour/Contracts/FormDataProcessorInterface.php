<?php

namespace WebTheory\Saveyour\Contracts;

interface FormDataProcessorInterface
{
    /**
     *
     */
    public function run($request, $results);

    /**
     *
     */
    public function getFields(): array;
}
