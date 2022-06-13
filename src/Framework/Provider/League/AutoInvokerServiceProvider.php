<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Framework\Provider\AutoInvokerProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class AutoInvokerServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'invoker';
    }

    protected function types(): array
    {
        return [AutoInvokerInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new AutoInvokerProvider();
    }

    protected function args(): ?array
    {
        return $this->getConfig('container.alias', []);
    }
}
