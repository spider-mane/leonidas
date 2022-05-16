<?php

namespace Leonidas\Framework\Providers\League;

class TwigAdminViewServiceProvider extends TwigViewServiceProvider
{
    protected function serviceId(): string
    {
        return 'twig.admin';
    }

    protected function factoryArgs(): ?array
    {
        return $this->getConfig('twig.admin');
    }
}
