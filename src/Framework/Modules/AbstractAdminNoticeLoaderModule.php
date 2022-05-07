<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Admin\Components\AdminNoticeHandlerInterface;
use Leonidas\Contracts\Admin\Components\AdminNoticePrinterInterface;
use Leonidas\Contracts\Admin\Components\AdminNoticeRepositoryInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Hooks\TargetsAllAdminNoticesHook;
use Leonidas\Hooks\TargetsShutdownHook;
use Leonidas\Library\Admin\Loaders\AdminNoticeHandler;

abstract class AbstractAdminNoticeLoaderModule extends AbstractModule implements ModuleInterface
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

    protected function doShutdownAction()
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

    protected function handler(bool $print = false): AdminNoticeHandlerInterface
    {
        return new AdminNoticeHandler($this->repository(), $print ? $this->printer() : null);
    }

    protected function printer(): ?AdminNoticePrinterInterface
    {
        return null;
    }

    abstract protected function repository(): AdminNoticeRepositoryInterface;
}
