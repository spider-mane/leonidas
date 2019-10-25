<?php

namespace WebTheory\Saveyour\Contracts;

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
