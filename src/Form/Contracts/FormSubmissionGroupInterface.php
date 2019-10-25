<?php

namespace WebTheory\Saveyour\Contracts;

interface FormSubmissionGroupInterface
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
