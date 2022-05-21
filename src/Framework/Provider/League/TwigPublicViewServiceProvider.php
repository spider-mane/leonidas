<?php

namespace Leonidas\Framework\Provider\League;

class TwigPublicViewServiceProvider extends TwigViewServiceProvider
{
    protected function serviceId(): string
    {
        return 'twig.public';
    }

    protected function factoryArgs(): ?array
    {
        return $this->getConfig('twig.public');
    }
}
