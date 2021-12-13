<?php

namespace WebTheory\Panamax\Interfaces;

use Psr\Container\ContainerInterface;

interface SimpleProviderInterface
{
    public function __construct(ContainerInterface $container);

    public function provide();

    public function boot();
}
