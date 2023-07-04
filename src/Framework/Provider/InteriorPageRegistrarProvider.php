<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Contracts\Admin\Registrar\InteriorPageRegistrarInterface;
use Leonidas\Library\Admin\Callback\AdminPageCallbackProvider;
use Leonidas\Library\Admin\Registrar\InteriorPageRegistrar;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class InteriorPageRegistrarProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): InteriorPageRegistrarInterface
    {
        return new InteriorPageRegistrar(
            $container->get(AdminPageCallbackProvider::class)
        );
    }
}
