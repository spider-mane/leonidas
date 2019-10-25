<?php

namespace WebTheory\Saveyour\Contracts;

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
