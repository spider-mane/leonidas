<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Library\Admin\Loaders\AdminNoticeCollectionLoader;
use Leonidas\Library\Admin\Loaders\AdminNoticeCollectionLoaderInterface;
use Psr\Container\ContainerInterface;

class AdminNoticeCollectionLoaderProvider implements StaticProviderInterface
{
    public static function provide(array $args, ContainerInterface $container): AdminNoticeCollectionLoaderInterface
    {
        $prefix = $args['prefix'];
        $loader = new AdminNoticeCollectionLoader("{$prefix}.adminNotices");
        $loader->hook();

        return $loader;
    }
}
