<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Auth\CsrfManagerRepositoryInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Traits\Hooks\TargetsInAdminHeaderHook;
use Leonidas\Traits\LoadsCsrfFieldsTrait;
use WP_Screen;

abstract class AbstractAdminCsrfLoaderModule extends AbstractModule implements ModuleInterface
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
        return $this->getExtension()->get(CsrfManagerRepositoryInterface::class);
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