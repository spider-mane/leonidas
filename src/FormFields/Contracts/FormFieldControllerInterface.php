<?php

namespace Backalley\FormFields\Contracts;


interface FormFieldControllerInterface
{
    /**
     *
     */
    public function getFormField(): FormFieldInterface;

    /**
     *
     */
    public function setFormField(FormFieldInterface $formField);

    /**
     *
     */
    public function renderFormField($object);
}
