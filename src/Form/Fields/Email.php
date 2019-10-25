<?php

namespace WebTheory\Saveyour\Fields;

use WebTheory\Saveyour\Contracts\FormFieldInterface;

class Email extends AbstractInput implements FormFieldInterface
{
    /**
     *
     */
    protected $type = 'email';
}
