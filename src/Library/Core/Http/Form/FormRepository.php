<?php

namespace Leonidas\Library\Core\Http\Form;

use Leonidas\Contracts\Http\Form\FormControllerInterface;
use Leonidas\Contracts\Http\Form\FormRepositoryInterface;

class FormRepository implements FormRepositoryInterface
{
    /**
     * @var FormControllerInterface[]
     */
    protected $forms = [];

    /**
     *
     */
    public function register(string $id, FormControllerInterface $form)
    {
        $this->forms[$id] = $form;
    }

    public function getForm(string $id): FormControllerInterface
    {
        return $this->forms[$id];
    }

    /**
     *
     */
    public function build(string $form): array
    {
        return $this->getForm($form)->build();
    }
}
