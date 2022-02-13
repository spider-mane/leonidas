<?php

namespace Leonidas\Framework\Modules\Traits;

use Leonidas\Contracts\Http\Form\FormRepositoryInterface;

trait UsesRepositoryServiceTrait
{
    protected function repository(): FormRepositoryInterface
    {
        return $this->getService($this->formRepositoryService());
    }

    protected function formRepositoryService(): string
    {
        return 'form_handler_repository';
    }

    abstract protected function getService($service);
}
