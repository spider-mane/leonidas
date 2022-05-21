<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\PhoneNumberUtilProvider;
use libphonenumber\PhoneNumberUtil;
use Panamax\Contracts\ServiceFactoryInterface;

class PhoneNumberUtilServiceProvider extends AbstractLeagueServiceFactory
{
    protected function serviceId(): string
    {
        return PhoneNumberUtil::class;
    }

    protected function serviceTags(): array
    {
        return ['phone', 'phone_util', 'phoneUtil'];
    }

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new PhoneNumberUtilProvider();
    }

    protected function factoryArgs(): ?array
    {
        return $this->getConfig('phone.util');
    }
}
