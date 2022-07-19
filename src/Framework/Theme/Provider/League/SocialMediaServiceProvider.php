<?php

namespace Leonidas\Framework\Theme\Provider\League;

use Leonidas\Framework\Provider\ContextSelectorProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class SocialMediaServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'social_media';
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new ContextSelectorProvider();
    }

    protected function args(): ?array
    {
        $data = $this->container->get('data')->get('social_media');

        return [
            'selections' => $data['accounts'],
            'contexts' => $data['contexts'],
        ];
    }
}
