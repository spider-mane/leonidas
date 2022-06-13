<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\PostTypeProvider;
use Leonidas\Library\System\Model\PostType\PostTypeFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class PostTypeFactoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'post_type_factory';
    }

    protected function types(): array
    {
        return [PostTypeFactory::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new PostTypeProvider();
    }

    protected function args(): ?array
    {
        return [
            'prefix' => $this->getConfig('app.prefix'),
        ];
    }
}
