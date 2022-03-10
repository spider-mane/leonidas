<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Framework\Providers\SymfonyMailerProvider;
use Psr\Container\ContainerInterface;
use Symfony\Component\Mailer\Mailer;

class SymfonyMailerServiceProvider extends AbstractLeagueProviderWrapper
{
    protected function serviceId(): string
    {
        return Mailer::class;
    }

    protected function serviceTags(): array
    {
        return ['mailer', 'symfony_mailer', 'symfonyMailer'];
    }

    protected function serviceProvider(): StaticProviderInterface
    {
        return new SymfonyMailerProvider();
    }

    protected function providerArgs(ContainerInterface $container): ?array
    {
        return $this->getConfig('mail');
    }
}
