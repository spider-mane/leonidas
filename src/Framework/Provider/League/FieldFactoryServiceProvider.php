<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\FieldFactoryProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Panamax\Contracts\ServiceFactoryInterface;
use WebTheory\Saveyour\Factory\FieldFactory;

class FieldFactoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'fields';
    }

    protected function types(): array
    {
        return [FieldFactory::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new FieldFactoryProvider();
    }

    protected function args(): ?array
    {
        return $this->getConfig('view.fields');
    }
}
