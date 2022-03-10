<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Framework\Providers\AdminNoticeRepositoryProvider;
use Leonidas\Library\Admin\Notice\AdminNoticeRepository;
use Psr\Container\ContainerInterface;

class AdminNoticeRepositoryServiceProvider extends AbstractLeagueProviderWrapper
{
    protected function serviceId(): string
    {
        return AdminNoticeRepository::class;
    }

    protected function serviceTags(): array
    {
        return ['admin_notices', 'adminNotices'];
    }

    protected function serviceProvider(): StaticProviderInterface
    {
        return new AdminNoticeRepositoryProvider();
    }

    protected function providerArgs(ContainerInterface $container): ?array
    {
        return $this->getConfig('admin.notices');
    }
}
