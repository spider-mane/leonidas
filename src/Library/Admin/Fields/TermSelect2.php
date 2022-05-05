<?php

namespace Leonidas\Library\Admin\Fields;

use WebTheory\Saveyour\Contracts\Controller\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\Field\FormFieldInterface;
use WebTheory\Saveyour\Field\Type\Select2;

class TermSelect2 extends TermSelect implements FormFieldControllerInterface
{
    protected function defineFormField(): FormFieldInterface
    {
        $options = $this->options;

        return (new Select2())
            ->setSelectionProvider($this->createSelection())
            ->setMultiple($options['multiple'])
            ->setId($options['id'])
            ->setClasslist($options['class']);
    }
}
