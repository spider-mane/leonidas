<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Admin\Loader\AdminNoticeLoaderInterface;
use Leonidas\Contracts\Admin\Printer\AdminNoticePrinterInterface;
use Leonidas\Contracts\Admin\Repository\AdminNoticeRepositoryInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Hooks\TargetsAllAdminNoticesHook;
use Leonidas\Hooks\TargetsShutdownHook;
use Leonidas\Library\Admin\Loader\AdminNoticeLoader;

abstract class AdminNoticeLoaderModule extends Module implements ModuleInterface
{
    use TargetsAllAdminNoticesHook;
    use TargetsShutdownHook;

    public function hook(): void
    {
        $this->targetAllAdminNoticesHook();
        $this->targetShutdownHook();
    }

    protected function doAllAdminNoticesAction(): void
    {
        $this->printNotices();
    }

    protected function doShutdownAction(): void
    {
        if (is_admin() && did_action('wp_redirect')) {
            $this->stashCollectedNotices();
        }
    }

    protected function printNotices(): void
    {
        $request = $this->getServerRequest()
            ->withAttribute('screen', get_current_screen()->id)
            ->withAttribute('user', get_current_user());

        echo $this->handler(true)->print($request);
    }

    protected function stashCollectedNotices(): void
    {
        $this->repository()->persist($this->getServerRequest());
    }

    protected function handler(bool $print = false): AdminNoticeLoaderInterface
    {
        return new AdminNoticeLoader($this->repository(), $print ? $this->printer() : null);
    }

    protected function printer(): ?AdminNoticePrinterInterface
    {
        return null;
    }

    abstract protected function repository(): AdminNoticeRepositoryInterface;
}
