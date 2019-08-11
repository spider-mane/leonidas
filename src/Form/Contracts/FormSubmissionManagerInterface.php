<?php

namespace Backalley\Form\Contracts;

interface FormSubmissionManagerInterface
{
    /**
     *
     */
    public function saveInput($request): bool;

    /**
     *
     */
    public function getFilteredInput();
}
