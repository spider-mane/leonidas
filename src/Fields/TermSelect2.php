<?php

namespace WebTheory\Leonidas\Fields;

use WebTheory\Leonidas\Fields\Selections\TaxonomySelectOptions;
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
            ->setSelectionProvider(new TaxonomySelectOptions($this->taxonomy))
            ->setMultiple($options['multiple'])
            ->setId($options['id'])
            ->setClasslist($options['class']);
    }
}
