<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Contracts\Http\Form\FormRepositoryInterface;
use Leonidas\Framework\Providers\FormRepositoryProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class FormRepositoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function serviceId(): string
    {
        return FormRepositoryInterface::class;
    }

    protected function serviceTags(): array
    {
        return ['forms', 'form_repository', 'formRepository'];
    }

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new FormRepositoryProvider();
    }
}
