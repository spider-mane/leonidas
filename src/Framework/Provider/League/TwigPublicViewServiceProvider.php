<?php

namespace Leonidas\Framework\Provider\League;

class TwigPublicViewServiceProvider extends TwigViewServiceProvider
{
    protected function id(): string
    {
        return 'twig.public';
    }

    protected function types(): array
    {
        return [];
    }

    protected function aliases(): array
    {
        return ['views.public', 'templates.public'];
    }

    protected function args(): ?array
    {
        return $this->getConfig('twig.public');
    }
}
