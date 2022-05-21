<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Http\Form\FormHandlerRepositoryInterface;
use Leonidas\Framework\Provider\FormHandlerRepositoryProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class FormHandlerRepositoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function serviceId(): string
    {
        return FormHandlerRepositoryInterface::class;
    }

    protected function serviceTags(): array
    {
        return ['forms', 'form_repository', 'formRepository'];
    }

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new FormHandlerRepositoryProvider();
    }
}
