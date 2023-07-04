<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Contracts\Admin\Registrar\SubmenuPageRegistrarInterface;
use Leonidas\Library\Admin\Callback\AdminPageCallbackProvider;
use Leonidas\Library\Admin\Registrar\SubmenuPageRegistrar;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class SubmenuPageRegistrarProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): SubmenuPageRegistrarInterface
    {
        return new SubmenuPageRegistrar(
            $container->get(AdminPageCallbackProvider::class)
        );
    }
}
