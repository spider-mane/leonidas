<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Contracts\Admin\Registrar\FlexPageRegistrarInterface;
use Leonidas\Library\Admin\Callback\AdminPageCallbackProvider;
use Leonidas\Library\Admin\Registrar\FlexPageRegistrar;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class FlexPageRegistrarProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): FlexPageRegistrarInterface
    {
        return new FlexPageRegistrar(
            $container->get(AdminPageCallbackProvider::class)
        );
    }
}
