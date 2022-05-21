<?php

namespace Leonidas\Library\Core\Http\Form;

use Leonidas\Contracts\Http\Form\FormInterface;
use Leonidas\Contracts\Http\Form\FormRepositoryInterface;
use LogicException;

class FormRepository implements FormRepositoryInterface
{
    protected array $forms = [];

    protected array $map = [];

    public function add(FormInterface $form): void
    {
        $handle = $form->getHandle();
        $action = $form->getAction();

        if (!$this->alreadyHasFormWith($handle, $action)) {
            $this->forms[$form->getHandle()] = $form;
            $this->map[$form->getAction()] = $handle;
        }

        throw new LogicException(sprintf(
            "Form with handle \"%s\" and/or action \"%s\" already exists.",
            $handle,
            $action
        ));
    }

    public function fetch(string $handle): FormInterface
    {
        return $this->forms[$handle];
    }

    public function mapped(string $action): FormInterface
    {
        return $this->forms[$this->map[$action]];
    }

    protected function alreadyHasFormWith(string $handle, string $action): bool
    {
        return isset($this->forms[$handle]) || isset($this->map[$action]);
    }
}
