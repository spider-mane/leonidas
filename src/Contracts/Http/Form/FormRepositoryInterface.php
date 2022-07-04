<?php

namespace Leonidas\Contracts\Http\Form;

use LogicException;

interface FormRepositoryInterface
{
    /**
     * Adds form to repository. Must ensure that both handle and action are
     * unique to repository and that the form can be retrieved by either.
     *
     * @param FormInterface $form
     *
     * @throws LogicException if form with handle or action already present.
     *
     * @return void
     */
    public function add(FormInterface $form): void;

    public function fetch(string $handle): FormInterface;

    public function mapped(string $action): FormInterface;
}
