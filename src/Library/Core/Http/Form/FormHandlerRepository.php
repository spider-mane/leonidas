<?php

namespace Leonidas\Library\Core\Http\Form;

use Leonidas\Contracts\Http\Form\FormHandlerInterface;
use Leonidas\Contracts\Http\Form\FormHandlerRepositoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class FormHandlerRepository implements FormHandlerRepositoryInterface
{
    /**
     * @var FormHandlerInterface[]
     */
    protected array $forms = [];

    public function add(FormHandlerInterface $form)
    {
        $this->forms[$form->getHandle()] = $form;
    }

    public function get(string $handle): FormHandlerInterface
    {
        return $this->forms[$handle];
    }

    public function getBuild(string $handle, ServerRequestInterface $request): array
    {
        return $this->get($handle)->build($request);
    }
}
