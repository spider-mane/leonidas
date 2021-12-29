<?php

namespace Leonidas\Framework\Modules\Traits;

use Leonidas\Traits\Hooks\TargetsAdminNoticesHook;
use Leonidas\Traits\Hooks\TargetsWpRedirectHook;
use Psr\SimpleCache\CacheInterface;

trait ProcessesSettingsTrait
{
    use AbstractModuleTraitTrait;
    use TargetsAdminNoticesHook;
    use TargetsWpRedirectHook;

    public function hook(): void
    {
        $this->targetAdminNoticesHook();
        $this->targetWpRedirectHook();
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

    // abstract protected function notices(): AdminNoticeCollectionInterface;
}
