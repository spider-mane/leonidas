<?php

namespace WebTheory\Form\Fields;

use WebTheory\Form\Contracts\FormFieldInterface;

class Email extends AbstractInput implements FormFieldInterface
{
    /**
     *
     */
    protected $type = 'email';
}
