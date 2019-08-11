<?php

namespace Backalley\Form\Contracts;

interface FormFieldControllerInterface extends FormSubmissionManagerInterface
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
    public function renderFormField($request);

    /**
     *
     */
    public function getFormFieldName(): string;

    /**
     *
     */
    public function setFormFieldValue($request);

    /**
     *
     */
    public function hasDataManager(): bool;

    /**
     *
     */
    public function getStateParameter(string $state);

    /**
     *
     */
    public function resetStateCache(string $nonce);
}
