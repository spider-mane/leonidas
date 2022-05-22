<?php

namespace Leonidas\Library\Admin\Field;

use WebTheory\Saveyour\Contracts\Controller\FormFieldControllerInterface;
use WebTheory\Saveyour\Contracts\Field\FormFieldInterface;
use WebTheory\Saveyour\Field\Type\Select2;

class TermSelect2 extends TermSelect implements FormFieldControllerInterface
{
    protected function defineFormField(): FormFieldInterface
    {
        $options = $this->options;

        $select2 = new Select2();

        $select2->setSelectionProvider($this->createSelection());
        $select2->setMultiple($options['multiple']);
        $select2->setId($options['id']);
        $select2->setClasslist($options['class']);

        return $select2;
    }
}
