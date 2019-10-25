<?php

namespace WebTheory\Saveyour\Fields;

use WebTheory\Saveyour\Contracts\FormFieldInterface;

class Hidden extends AbstractInput implements FormFieldInterface
{
    /**
     *
     */
    protected $type = 'hidden';
}
