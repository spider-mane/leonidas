<?php

namespace WebTheory\Leonidas\Framework\Modules;

use Closure;
use WP_Screen;
use WebTheory\Leonidas\Admin\Contracts\ModuleInterface;
use WebTheory\Leonidas\Concerns\Hooks\LoadsCsrfFieldsTrait;
use WebTheory\Leonidas\Contracts\Dashboard\ScreenInterface;
use WebTheory\Leonidas\Core\Auth\CsrfManagerRepository;
use WebTheory\Leonidas\Contracts\Auth\CsrfManagerInterface;
use WebTheory\Leonidas\Framework\Traits\Hooks\TargetsInAdminHeaderHook;

abstract class AbstractCsrfFieldLoaderModule extends AbstractModule implements ModuleInterface
{
    use LoadsCsrfFieldsTrait;
    use TargetsInAdminHeaderHook;

    public function hook(): void
    {
        $this->targetInAdminHeaderHook();
    }

    protected function doInAdminHeaderAction(): void
    {
        echo $this->renderCsrfFields();
    }

    protected function getManagerRepository(): CsrfManagerRepository
    {
        return $this->extension->get(CsrfManagerRepository::class);
    }

    protected function getRequiredManagerTags(): array
    {
        return $this->getManagersForScreen(get_current_screen());
    }

    /**
     * Return an array of
     *
     * @return string[]
     */
    abstract protected function getManagersForScreen(WP_Screen $screen): array;
}
