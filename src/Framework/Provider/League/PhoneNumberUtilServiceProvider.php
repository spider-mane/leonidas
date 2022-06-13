<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\PhoneNumberUtilProvider;
use libphonenumber\PhoneNumberUtil;
use Panamax\Contracts\ServiceFactoryInterface;

class PhoneNumberUtilServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'phone';
    }

    protected function types(): array
    {
        return [PhoneNumberUtil::class];
    }

    protected function aliases(): array
    {
        return ['phone_util', 'phoneUtil'];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new PhoneNumberUtilProvider();
    }

    protected function args(): ?array
    {
        return $this->getConfig('phone.util');
    }
}
