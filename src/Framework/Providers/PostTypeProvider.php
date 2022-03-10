<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Library\System\PostType\PostTypeFactory;
use Psr\Container\ContainerInterface;

class PostTypeProvider implements StaticProviderInterface
{
    public static function provide(ContainerInterface $container, array $args = []): PostTypeFactory
    {
        return new PostTypeFactory($args['prefix']);
    }
}
