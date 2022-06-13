<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Http\Form\FormHandlerRepositoryInterface;
use Leonidas\Framework\Provider\FormHandlerRepositoryProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class FormHandlerRepositoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'forms';
    }

    protected function types(): array
    {
        return [FormHandlerRepositoryInterface::class];
    }

    protected function aliases(): array
    {
        return ['form_repository', 'formRepository'];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new FormHandlerRepositoryProvider();
    }
}
