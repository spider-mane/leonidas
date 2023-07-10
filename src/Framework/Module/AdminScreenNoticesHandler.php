<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Admin\Loader\AdminNoticeLoaderInterface;
use Leonidas\Contracts\Admin\Repository\AdminNoticeRepositoryInterface;
use Leonidas\Framework\Module\Abstracts\Module;
use Leonidas\Hooks\TargetsAllAdminNoticesHook;
use Leonidas\Hooks\TargetsShutdownHook;
use Psr\Http\Message\ServerRequestInterface;

class AdminScreenNoticesHandler extends Module
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
        $request = $this->getServerRequest()
            ->withAttribute('screen', get_current_screen())
            ->withAttribute('user', wp_get_current_user());

        $this->printNotices($request);
    }

    protected function doShutdownAction(): void
    {
        if ($this->isCompletedAdminRequest()) {
            $request = $this->getServerRequest();

            $this->updateRepository($request);
        }
    }

    protected function isCompletedAdminRequest(): bool
    {
        return is_admin() && did_action('wp_loaded');
    }

    protected function printNotices($request): void
    {
        echo $this->loader()->printAll($request);
    }

    protected function updateRepository(ServerRequestInterface $request): void
    {
        $this->repository()->persist($request);
    }

    protected function loader(): AdminNoticeLoaderInterface
    {
        return $this->getService(AdminNoticeLoaderInterface::class);
    }

    protected function repository(): AdminNoticeRepositoryInterface
    {
        return $this->getService(AdminNoticeRepositoryInterface::class);
    }
}
