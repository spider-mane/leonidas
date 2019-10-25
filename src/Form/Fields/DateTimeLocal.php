<?php

namespace WebTheory\Saveyour\Fields;

use WebTheory\Saveyour\Contracts\FormFieldInterface;

class DateTimeLocal extends AbstractInput implements FormFieldInterface
{
    /**
     *
     */
    protected $type = 'datetime-local';
}
