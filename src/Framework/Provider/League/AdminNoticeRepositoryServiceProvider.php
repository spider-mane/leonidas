<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Admin\Repository\AdminNoticeRepositoryInterface;
use Leonidas\Framework\Provider\AdminNoticeRepositoryProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class AdminNoticeRepositoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'admin_notices';
    }

    protected function aliases(): array
    {
        return ['adminNotices'];
    }

    protected function types(): array
    {
        return [AdminNoticeRepositoryInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new AdminNoticeRepositoryProvider();
    }
}
