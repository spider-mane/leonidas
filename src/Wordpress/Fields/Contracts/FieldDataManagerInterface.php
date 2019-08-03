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
    public function getData($object);

    /**
     *
     */
    public function saveData($object, $data);
}
