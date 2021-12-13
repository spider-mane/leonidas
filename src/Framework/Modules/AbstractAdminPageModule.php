<?php

namespace Leonidas\Framework\Modules;

use DateInterval;
use GuzzleHttp\Psr7\Request;
use Leonidas\Contracts\Admin\Components\AdminPageInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Traits\Hooks\TargetsAdminMenuHook;
use Leonidas\Traits\Hooks\TargetsAdminNoticesHook;
use Leonidas\Traits\Hooks\TargetsAdminTitleHook;
use Leonidas\Traits\Hooks\TargetsWpRedirectHook;
use Psr\SimpleCache\CacheInterface;
use Stringable;

abstract class AbstractAdminPageModule extends AbstractModule implements ModuleInterface
{
    use TargetsAdminMenuHook;
    use TargetsAdminTitleHook;
    use TargetsAdminNoticesHook;
    use TargetsWpRedirectHook;

    protected AdminPageInterface $definition;

    protected string|Stringable $cacheKey;

    protected null|int|DateInterval $cacheTtl = HOUR_IN_SECONDS;

    public function hook(): void
    {
        $this->targetAdminMenuHook();
        $this->targetAdminTitleHook();
    }

    protected function init(): AbstractAdminPageModule
    {
        $this->definition = $this->definition();

        return $this;
    }

    protected function doAdminMenuAction(string $context): void
    {
        $this->init()->addPage()->configurePage();
    }

    protected function filterAdminTitle(string $adminTitle, string $title): string
    {
        return $this->definition->defineAdminTitle($adminTitle, $title);
    }

    protected function doAdminNoticesAction(): void
    {
        /** @var AdminNoticeInterface[] $notices */
        if (!$notices = $this->cache()->get($this->adminNoticeCacheKey())) {
            return;
        }

        $request = $this->getServerRequest();
        $output = '';

        foreach ($notices as $notice) {
            if ($notice->shouldBeRendered($request)) {
                $output .= $notice->renderComponent($request);
            }
        }

        $this->cache()->delete($this->adminNoticeCacheKey());

        echo $output;
    }

    protected function filterWpRedirect(string $location, int $status): string
    {
        if (is_admin() && $this->hasNotices()) {
            $this->cache()->set(
                $this->adminNoticeCacheKey(),
                $this->adminNotices(),
            );
        }

        return $location;
    }

    protected function configurePage(): AbstractAdminPageModule
    {
        if (!$this->definition->isShownInMenu()) {
            $this->removePage();
        }

        return $this;
    }

    protected function renderPage(array $args): void
    {
        $request = $this->getServerRequest()->withAttribute('args', $args);

        if ($this->definition->shouldBeRendered($request)) {
            echo $this->definition->renderComponent($request);
        }
    }

    protected function cache(): CacheInterface
    {
        return $this->getExtension()->get(CacheInterface::class);
    }

    protected function cacheTtl()
    {
        return $this->cacheTtl;
    }

    protected function adminNoticeCacheKey(): string
    {
        return $this->cacheKey;
    }

    protected function adminNotices(): array
    {
        return $this->definition->getNotices();
    }

    abstract protected function addPage(): AbstractAdminPageModule;

    abstract protected function removePage(): AbstractAdminPageModule;

    abstract protected function definition(): AdminPageInterface;

    // abstract protected function notices(): AdminNoticeCollectionInterface;
}
