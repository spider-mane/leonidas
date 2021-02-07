<?php

namespace WebTheory\Leonidas\Admin\Fields;

use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\FormFieldInterface;
use WebTheory\Saveyour\Fields\Select2;

class TermSelect2 extends TermSelect implements FormFieldControllerInterface
{
    /**
     *
     */
    protected function defineFormField(): FormFieldInterface
    {
        $options = $this->options;

        return (new Select2)
            ->setSelectionProvider($this->createSelection())
            ->setMultiple($options['multiple'])
            ->setId($options['id'])
            ->setClasslist($options['class']);
    }
}
