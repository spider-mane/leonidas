<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Library\Core\Cache\TransientsChannel;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class TransientsChannelProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): TransientsChannel
    {
        return new TransientsChannel($args['channel']);
    }
}
