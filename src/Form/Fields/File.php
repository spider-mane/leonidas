<?php

namespace WebTheory\Saveyour\Fields;

use WebTheory\Saveyour\Contracts\FormFieldInterface;

class File extends AbstractInput implements FormFieldInterface
{
    /**
     *
     */
    protected $type = 'file';
}
