<?php

namespace Backalley\Wordpress\Fields\Contracts;

interface FormSubmissionManagerInterface
{
    /**
     *
     */
    public function saveInput(...$request): bool;

    /**
     *
     */
    public function getFilteredInput();
}
