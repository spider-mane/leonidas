<?php

namespace Leonidas\Framework\Providers\League;

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

    protected function factoryArgs(): ?array
    {
        return $this->getConfig('twig.admin');
    }
}
