<?php

namespace Backalley\Form\Controllers;

use Backalley\FormFields\Contracts\FormFieldControllerInterface;
use Backalley\FormFields\Contracts\FormFieldInterface;


class SimpleField implements FormFieldControllerInterface
{
    /**
     * @var FormFieldInterface
     */
    protected $formField;

    /**
     *
     */
    public function __construct(FormFieldInterface $formField)
    {
        $this->setFormField($formField);
    }

    /**
     * Get the value of formField
     *
     * @return FormFieldInterface
     */
    public function getFormField(): FormFieldInterface
    {
        return $this->formField;
    }

    /**
     * Set the value of formField
     *
     * @param FormFieldInterface $formField
     *
     * @return self
     */
    public function setFormField(FormFieldInterface $formField)
    {
        $this->formField = $formField;

        return $this;
    }
}
