<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Admin\Registrar\SettingsFieldRegistrarInterface;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\SettingsFieldRegistrarProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class SettingsFieldRegistrarServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'settings_field_registrar';
    }

    protected function types(): array
    {
        return [SettingsFieldRegistrarInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new SettingsFieldRegistrarProvider();
    }
}
