<?php

namespace WebTheory\Form\Fields;

use WebTheory\Form\Contracts\FormFieldInterface;

class Hidden extends AbstractInput implements FormFieldInterface
{
    /**
     *
     */
    protected $type = 'hidden';
}
