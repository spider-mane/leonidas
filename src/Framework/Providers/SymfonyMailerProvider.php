<?php

namespace Leonidas\Framework\Providers;

use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class SymfonyMailerProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = [])
    {
        // todo: read mailer docs!
    }
}
