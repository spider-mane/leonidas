<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Contracts\Admin\Registrar\MenuPageRegistrarInterface;
use Leonidas\Library\Admin\Callback\AdminPageCallbackProvider;
use Leonidas\Library\Admin\Registrar\MenuPageRegistrar;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class MenuPageRegistrarProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): MenuPageRegistrarInterface
    {
        return new MenuPageRegistrar(
            $container->get(AdminPageCallbackProvider::class)
        );
    }
}
