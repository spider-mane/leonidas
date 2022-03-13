<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Framework\Providers\PostTypeProvider;
use Leonidas\Library\System\PostType\PostTypeFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class PostTypeFactoryServiceProvider extends AbstractLeagueProviderWrapper
{
    protected function serviceId(): string
    {
        return PostTypeFactory::class;
    }

    protected function serviceTags(): array
    {
        return ['post_type_factory'];
    }

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new PostTypeProvider();
    }

    protected function factoryArgs(): ?array
    {
        return [
            'prefix' => $this->getConfig('app.prefix'),
        ];
    }
}
