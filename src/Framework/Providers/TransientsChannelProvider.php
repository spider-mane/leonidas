<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Library\Core\Cache\TransientsChannel;
use Psr\Container\ContainerInterface;

class TransientsChannelProvider implements StaticProviderInterface
{
    public static function provide(ContainerInterface $container, array $args = [])
    {
        return new TransientsChannel($args['channel']);
    }
}
