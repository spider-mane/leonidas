<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Admin\Loader\AdminNoticeLoaderInterface;
use Leonidas\Framework\Provider\AdminNoticeLoaderProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class AdminNoticeLoaderServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'admin_notice_loader';
    }

    protected function types(): array
    {
        return [AdminNoticeLoaderInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new AdminNoticeLoaderProvider();
    }
}
