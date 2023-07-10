<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Contracts\Admin\Loader\AdminNoticeLoaderInterface;
use Leonidas\Contracts\Admin\Printer\AdminNoticePrinterInterface;
use Leonidas\Contracts\Admin\Repository\AdminNoticeRepositoryInterface;
use Leonidas\Library\Admin\Loader\AdminNoticeLoader;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class AdminNoticeLoaderProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): AdminNoticeLoaderInterface
    {
        return new AdminNoticeLoader(
            $container->get(AdminNoticeRepositoryInterface::class),
            $this->fetch(AdminNoticePrinterInterface::class, $container)
        );
    }
}
