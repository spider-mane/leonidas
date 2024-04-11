<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Library\System\Schema\Post\RelatablePostKeys;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class RelatablePostKeyProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = [])
    {
        return new RelatablePostKeys($args['prefix'] ?? 'post:');
    }
}
