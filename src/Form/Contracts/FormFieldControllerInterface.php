<?php

namespace WebTheory\Saveyour\Contracts;

use Respect\Validation\Validatable;
use WebTheory\Saveyour\Contracts\DataTransformerInterface;

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
    public function renderFormField($request): FormFieldInterface;

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
    public function setPostVar(string $postVar): FormFieldControllerInterface;

    /**
     *
     */
    public function getPostVar(): string;

    /**
     *
     */
    public function getStateParameter(string $state);

    /**
     *
     */
    public function resetStateCache(string $nonce);

    /**
     *
     */
    public function setSavingDisabled(bool $savingDisabled);

    /**
     *
     */
    public function isSavingDisabled(): bool;

    /**
     *
     */
    public function addRule(string $rule, Validatable $validator, ?string $alert = null);

    /**
     *
     */
    public function addAlert(string $rule, string $alert);

    /**
     *
     */
    public function getRules(): array;

    /**
     *
     */
    public function addFilter(callable $filter);

    /**
     *
     */
    public function setEscape(?callable $esc = null);

    /**
     *
     */
    public function getEscape();
}
