<?php

namespace Backalley\Form\Contracts;

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
