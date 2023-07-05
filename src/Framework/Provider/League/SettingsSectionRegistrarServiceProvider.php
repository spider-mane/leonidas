<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Admin\Registrar\SettingsSectionRegistrarInterface;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\SettingsSectionRegistrarProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class SettingsSectionRegistrarServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'settings_section_registrar';
    }

    protected function types(): array
    {
        return [SettingsSectionRegistrarInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new SettingsSectionRegistrarProvider();
    }
}
