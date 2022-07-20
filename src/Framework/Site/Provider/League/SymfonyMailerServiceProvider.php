<?php

namespace Leonidas\Framework\Site\Provider\League;

use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Site\Provider\SymfonyMailerProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Symfony\Component\Mailer\Mailer;

class SymfonyMailerServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'mailer';
    }

    protected function types(): array
    {
        return [Mailer::class];
    }

    protected function aliases(): array
    {
        return ['symfony_mailer', 'symfonyMailer'];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new SymfonyMailerProvider();
    }

    protected function args(): ?array
    {
        return $this->getConfig('mail');
    }
}
