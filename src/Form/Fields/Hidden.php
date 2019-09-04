<?php

namespace Backalley\Form\Fields;

use Backalley\Form\Contracts\FormFieldInterface;

class Hidden extends AbstractInput implements FormFieldInterface
{
    /**
     *
     */
    protected $type = 'hidden';
}
