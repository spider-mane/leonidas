<?php

namespace Backalley\Wordpress\Fields\Contracts;

use Backalley\Wordpress\Fields\Contracts\DataFieldInterface;


interface FieldDataManagerInterface
{
    /**
     *
     */
    public function setField(DataFieldInterface $field);

    /**
     *
     */
    public function createData($data, ...$request): bool;

    /**
     *
     */
    public function getData(...$request);

    /**
     *
     */
    public function saveData($data, ...$request): bool;

    /**
     *
     */
    public function deleteData(...$request);
}
