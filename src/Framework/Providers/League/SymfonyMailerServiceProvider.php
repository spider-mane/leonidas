<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Framework\Providers\SymfonyMailerProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Symfony\Component\Mailer\Mailer;

class SymfonyMailerServiceProvider extends AbstractLeagueServiceFactory
{
    protected function serviceId(): string
    {
        return Mailer::class;
    }

    protected function serviceTags(): array
    {
        return ['mailer', 'symfony_mailer', 'symfonyMailer'];
    }

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new SymfonyMailerProvider();
    }

    protected function factoryArgs(): ?array
    {
        return $this->getConfig('mail');
    }
}