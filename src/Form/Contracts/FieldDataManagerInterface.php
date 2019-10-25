<?php

namespace WebTheory\Form\Contracts;

interface FieldDataManagerInterface
{
    /**
     *
     */
    public function getCurrentData($request);

    /**
     *
     */
    public function handleSubmittedData($request, $data): bool;
}
