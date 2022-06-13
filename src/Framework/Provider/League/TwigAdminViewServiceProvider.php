<?php

namespace Leonidas\Framework\Provider\League;

class TwigAdminViewServiceProvider extends TwigViewServiceProvider
{
    protected function id(): string
    {
        return 'twig.admin';
    }

    protected function types(): array
    {
        return [];
    }

    protected function aliases(): array
    {
        return ['views.admin', 'templates.admin'];
    }

    protected function args(): ?array
    {
        return $this->getConfig('twig.admin');
    }
}
