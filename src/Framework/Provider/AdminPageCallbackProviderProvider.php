<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Contracts\Admin\Callback\AdminPageCallbackProviderInterface;
use Leonidas\Library\Admin\Callback\AdminPageCallbackProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class AdminPageCallbackProviderProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): AdminPageCallbackProviderInterface
    {
        return new AdminPageCallbackProvider();
    }
}
