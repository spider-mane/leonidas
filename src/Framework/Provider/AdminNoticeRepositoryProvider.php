<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Contracts\Admin\Repository\AdminNoticeRepositoryInterface;
use Leonidas\Library\Admin\Repository\AdminNoticeRepository;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class AdminNoticeRepositoryProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): AdminNoticeRepositoryInterface
    {
        return new AdminNoticeRepository($container->get('cache_channel'));
    }
}
