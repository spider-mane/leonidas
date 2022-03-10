<?php

namespace Leonidas\Framework\Providers\League;

use Psr\Container\ContainerInterface;

class AdminTwigViewServiceProvider extends TwigViewServiceProvider
{
    protected function serviceId(): string
    {
        return 'views.admin';
    }

    protected function serviceTags(): array
    {
        return [
            'twig.admin',
            'templates.admin',
            'admin.templates',
            'admin.views',
        ];
    }

    protected function providerArgs(ContainerInterface $container): ?array
    {
        return $this->getConfig('twig.admin');
    }
}
