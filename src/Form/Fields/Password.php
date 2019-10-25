<?php

namespace WebTheory\Form\Fields;

use WebTheory\Form\Contracts\FormFieldInterface;

class Password extends AbstractInput implements FormFieldInterface
{
    /**
     *
     */
    protected $type = 'password';
}
