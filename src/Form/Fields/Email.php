<?php

namespace Backalley\Form\Fields;

use Backalley\Form\Contracts\FormFieldInterface;

class Email extends AbstractInput implements FormFieldInterface
{
    /**
     *
     */
    protected $type = 'email';
}
