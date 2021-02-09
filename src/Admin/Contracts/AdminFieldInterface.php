<?php

namespace WebTheory\Leonidas\Admin\Contracts;

use WebTheory\Saveyour\Contracts\FormFieldControllerInterface;

interface AdminFieldInterface extends AdminComponentInterface
{
    /**
     *
     */
    public function setDescription(string $description);

    /**
     *
     */
    public function getDescription(): string;

    /**
     *
     */
    public function setLabel(string $label);

    /**
     *
     */
    public function getLabel(): string;

    /**
     *
     */
    public function getFormFieldController(): FormFieldControllerInterface;
}
