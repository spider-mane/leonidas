<?php

namespace Backalley\Form\Contracts;

interface FieldDataManagerInterface
{
    /**
     * Create
     */
    public function createData($request, $data): bool;

    /**
     * Read
     */
    public function getData($request);

    /**
     * Update
     */
    public function saveData($request, $data): bool;

    /**
     * Delete
     */
    public function deleteData($request);
}
