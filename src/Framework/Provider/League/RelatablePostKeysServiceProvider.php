<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\System\Schema\Post\RelatablePostKeyInterface;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\RelatablePostKeyProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class RelatablePostKeysServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'relatable_post_keys';
    }

    protected function types(): array
    {
        return [RelatablePostKeyInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new RelatablePostKeyProvider();
    }
}
