<?php

namespace Leonidas\Framework\Providers\League;

use Psr\Container\ContainerInterface;

class AdminFieldFactoryServiceProvider extends FieldFactoryServiceProvider
{
    protected function serviceId(): string
    {
        return 'admin_field_factory';
    }

    protected function serviceTags(): array
    {
        return [];
    }

    protected function providerArgs(ContainerInterface $container): ?array
    {
        return $this->getConfig('admin.fields');
    }
}
