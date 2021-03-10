<?php

namespace Leonidas\Framework\Modules;

use Closure;
use WP_Screen;
use Leonidas\Contracts\Auth\CsrfManagerInterface;
use Leonidas\Contracts\Auth\CsrfManagerRepositoryInterface;
use Leonidas\Contracts\Dashboard\ScreenInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Library\Core\Auth\CsrfManagerRepository;
use Leonidas\Traits\Hooks\TargetsInAdminHeaderHook;
use Leonidas\Traits\LoadsCsrfFieldsTrait;

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

    protected function getManagerRepository(): CsrfManagerRepositoryInterface
    {
        return $this->extension->get(CsrfManagerRepositoryInterface::class);
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
