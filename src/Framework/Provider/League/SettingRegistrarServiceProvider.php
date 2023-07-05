<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Admin\Processing\Setting\SettingRegistrarInterface;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\SettingRegistrarProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class SettingRegistrarServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'setting_registrar';
    }

    protected function types(): array
    {
        return [SettingRegistrarInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new SettingRegistrarProvider();
    }
}
