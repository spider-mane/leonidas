<?php

namespace Leonidas\Library\Core\Http\Form;

use Leonidas\Contracts\Http\Form\FormHandlerInterface;
use Leonidas\Contracts\Http\Form\FormRepositoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class FormRepository implements FormRepositoryInterface
{
    /**
     * @var FormHandlerInterface[]
     */
    protected array $forms = [];

    public function add(string $id, FormHandlerInterface $form)
    {
        $this->forms[$id] = $form;
    }

    public function get(string $id): FormHandlerInterface
    {
        return $this->forms[$id];
    }

    public function getBuild(string $form, ServerRequestInterface $request): array
    {
        return $this->get($form)->getBuild($request);
    }
}
