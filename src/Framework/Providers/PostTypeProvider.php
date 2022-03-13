<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Library\System\PostType\PostTypeFactory;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class PostTypeProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): PostTypeFactory
    {
        return new PostTypeFactory($args['prefix']);
    }
}
