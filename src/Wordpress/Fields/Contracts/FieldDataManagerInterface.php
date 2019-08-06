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
    public function createData($object, $data);

    /**
     *
     */
    public function getData($object);

    /**
     *
     */
    public function saveData($object, $data);

    /**
     *
     */
    public function deleteData($object);
}
