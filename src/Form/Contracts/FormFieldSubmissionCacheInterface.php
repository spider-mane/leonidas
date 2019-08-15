<?php

namespace Backalley\Form\Contracts;

interface FormFieldSubmissionCacheInterface
{
    /**
     *
     */
    public function wasSaveAttempted(): bool;

    /**
     *
     */
    public function SetWasSaveAttempted();

    /**
     *
     */
    public function wasSaveSuccessful(): bool;

    /**
     *
     */
    public function SetWasSaveSuccessful(bool $wasSaveSuccessful);

    /**
     *
     */
    public function wasPostVarPresent(): bool;

    /**
     *
     */
    public function SetWasPostVarPresent(bool $wasPostVarPresent);

    /**
     *
     */
    public function getInputValue(): bool;

    /**
     *
     */
    public function setInputValue($inputValue);

    /**
     *
     */
    public function getViolations(): bool;

    /**
     *
     */
    public function setViolations(array $violations);

    /**
     *
     */
    public function toReadOnly();
}
