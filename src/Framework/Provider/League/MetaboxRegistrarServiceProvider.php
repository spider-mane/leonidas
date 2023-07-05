<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Admin\Registrar\MetaboxRegistrarInterface;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\MetaboxRegistrarProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class MetaboxRegistrarServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'metabox_registrar';
    }

    protected function types(): array
    {
        return [MetaboxRegistrarInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new MetaboxRegistrarProvider();
    }
}
