<?php

namespace Backalley\FormFields\Contracts;

use Backalley\Wordpress\Fields\Contracts\FormSubmissionManagerInterface;

interface FormFieldControllerInterface extends FormSubmissionManagerInterface
{
    // /**
    //  *
    //  */
    // public function getFormField(): FormFieldInterface;

    // /**
    //  *
    //  */
    // public function setFormField(FormFieldInterface $formField);

    /**
     *
     */
    public function renderFormField(...$request);

    /**
     *
     */
    public function getFormFieldName(): string;

    /**
     *
     */
    public function setFormFieldValue(...$request);
}
