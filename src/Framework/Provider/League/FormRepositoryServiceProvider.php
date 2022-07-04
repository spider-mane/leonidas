<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Http\Form\FormRepositoryInterface;
use Leonidas\Framework\Provider\FormRepositoryProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class FormRepositoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'forms';
    }

    protected function types(): array
    {
        return [FormRepositoryInterface::class];
    }

    protected function aliases(): array
    {
        return ['form_repository', 'formRepository'];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new FormRepositoryProvider();
    }
}
