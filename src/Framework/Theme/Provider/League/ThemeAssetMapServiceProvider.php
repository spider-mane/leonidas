<?php

namespace Leonidas\Framework\Theme\Provider\League;

use Leonidas\Framework\Provider\AssetResourcesProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class ThemeAssetMapServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'theme_assets';
    }

    protected function aliases(): array
    {
        return ['theme_asset_map'];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new AssetResourcesProvider();
    }

    protected function args(): ?array
    {
        $url = $this->container->get('url');
        $config = $this->getConfig('view');

        return [
            'base' => $url . '/' . $config['assets'],
            'types' => $config['asset_types'],
        ];
    }
}
