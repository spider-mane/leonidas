<?php

namespace Backalley\Form\Fields;

use Backalley\Form\Contracts\FormFieldInterface;

abstract class AbstractStandardFormControl extends AbstractFormField implements FormFieldInterface
{
    /**
     *
     */
    protected function resolveAttributes()
    {
        return parent::resolveAttributes()
            ->addAttribute('name', $this->name)
            ->addAttribute('disabled', $this->disabled)
            ->addAttribute('readonly', $this->readonly)
            ->addAttribute('required', $this->required)
            ->addAttribute('placeholder', $this->placeholder);
    }
}
