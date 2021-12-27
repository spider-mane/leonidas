<?php

namespace Leonidas\Framework\Providers\League;

use League\Container\ServiceProvider\AbstractServiceProvider;
use libphonenumber\PhoneNumberUtil;

class PhoneNumberUtilServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function provides(string $id): bool
    {
        return in_array($id, [
            'phone',
            'phoneUtil',
            PhoneNumberUtil::class,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->getContainer()->addShared('phone', function () {
            return PhoneNumberUtil::getInstance();
        })->addTag(PhoneNumberUtil::class);
    }
}
