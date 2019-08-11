<?php

namespace Backalley\Form\Managers;

use Backalley\Form\Contracts\DataFieldInterface;
use Backalley\Form\Contracts\FieldDataManagerInterface;

abstract class AbstractFieldDataManager implements FieldDataManagerInterface
{
    /**
     * @var DataFieldInterface
     */
    protected $field;

    /**
     *
     */
    public function setField(DataFieldInterface $field)
    {
        $this->field = $field;
    }
}
