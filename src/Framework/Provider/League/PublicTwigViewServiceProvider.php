<?php

namespace Leonidas\Framework\Provider\League;

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

    protected function factoryArgs(): ?array
    {
        return $this->getConfig('twig.public');
    }
}
