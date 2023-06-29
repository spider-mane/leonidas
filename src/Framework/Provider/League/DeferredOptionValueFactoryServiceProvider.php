<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\DeferredOptionValueFactoryProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Library\System\Configuration\Option\DeferredOptionValueFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class DeferredOptionValueFactoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'deferred_option_value_factory';
    }

    protected function types(): array
    {
        return [DeferredOptionValueFactory::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new DeferredOptionValueFactoryProvider();
    }
}
