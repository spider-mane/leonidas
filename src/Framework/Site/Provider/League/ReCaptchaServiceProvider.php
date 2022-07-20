<?php

namespace Leonidas\Framework\Site\Provider\League;

use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Site\Provider\ReCaptchaProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use ReCaptcha\ReCaptcha;

class ReCaptchaServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'reCaptcha';
    }

    protected function types(): array
    {
        return [ReCaptcha::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new ReCaptchaProvider();
    }

    protected function args(): ?array
    {
        return $this->getConfig('services.recaptcha.secret');
    }
}
