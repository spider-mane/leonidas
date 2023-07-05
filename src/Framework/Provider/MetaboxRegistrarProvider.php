<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Contracts\Admin\Registrar\MetaboxRegistrarInterface;
use Leonidas\Library\Admin\Callback\MetaboxCallbackProvider;
use Leonidas\Library\Admin\Registrar\MetaboxRegistrar;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class MetaboxRegistrarProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): MetaboxRegistrarInterface
    {
        return new MetaboxRegistrar(new MetaboxCallbackProvider());
    }
}
