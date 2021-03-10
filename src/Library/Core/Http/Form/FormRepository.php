<?php

namespace Leonidas\Library\Core\Http\Form;

use Leonidas\Contracts\Form\FormControllerInterface;

class FormRepository
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

    /**
     *
     */
    public function get(string $form)
    {
        return ($this->forms[$form])->build();
    }
}
