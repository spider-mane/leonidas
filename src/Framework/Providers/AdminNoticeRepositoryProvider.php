<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Admin\Components\AdminNoticeRepositoryInterface;
use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Library\Admin\Notice\AdminNoticeRepository;
use Psr\Container\ContainerInterface;

class AdminNoticeRepositoryProvider implements StaticProviderInterface
{
    public static function provide(ContainerInterface $container, array $args = []): AdminNoticeRepositoryInterface
    {
        return new AdminNoticeRepository(
            $args['channel'],
            $container->get('cache_channel')
        );
    }
}
