<?php

namespace Leonidas\Framework\Providers\League;

use Psr\Container\ContainerInterface;

class PublicTwigViewServiceProvider extends TwigViewServiceProvider
{
    protected function serviceId(): string
    {
        return 'views.public';
    }

    protected function serviceTags(): array
    {
        return ['twig.public', 'templates.public'];
    }

    protected function providerArgs(ContainerInterface $container): ?array
    {
        return $this->getConfig('twig.public');
    }
}
