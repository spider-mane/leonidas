<?php

namespace Backalley\Form\Contracts;

interface FieldDataManagerInterface
{
    /**
     *
     */
    public function setField(DataFieldInterface $field);

    /**
     *
     */
    public function createData($request, $data): bool;

    /**
     *
     */
    public function getData($request);

    /**
     *
     */
    public function saveData($request, $data): bool;

    /**
     *
     */
    public function deleteData($request);
}
