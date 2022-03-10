<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Contracts\Http\Form\FormRepositoryInterface;
use Leonidas\Framework\Providers\FormRepositoryProvider;

class FormRepositoryServiceProvider extends AbstractLeagueProviderWrapper
{
    protected function serviceId(): string
    {
        return FormRepositoryInterface::class;
    }

    protected function serviceTags(): array
    {
        return ['forms', 'form_repository', 'formRepository'];
    }

    protected function serviceProvider(): StaticProviderInterface
    {
        return new FormRepositoryProvider();
    }
}
