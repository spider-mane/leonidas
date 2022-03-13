<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Framework\Providers\PhoneNumberUtilProvider;
use libphonenumber\PhoneNumberUtil;
use Panamax\Contracts\ServiceFactoryInterface;

class PhoneNumberUtilServiceProvider extends AbstractLeagueProviderWrapper
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
