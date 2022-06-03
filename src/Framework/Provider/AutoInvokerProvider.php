<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\Core\Util\AutoInvoker;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class AutoInvokerProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): AutoInvokerInterface
    {
        return new AutoInvoker($container, $args['aliases'] ?? []);
    }
}
