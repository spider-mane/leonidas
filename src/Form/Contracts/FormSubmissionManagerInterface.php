<?php

namespace Backalley\Form\Contracts;

interface FormSubmissionManagerInterface
{
    /**
     *
     */
    public function saveInput($request);

    /**
     *
     */
    public function getFilteredInput();
}
