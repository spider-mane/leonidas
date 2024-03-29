<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Auth\CsrfManagerRepositoryInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\Abstracts\Traits\LoadsCsrfFieldsTrait;
use Leonidas\Hooks\TargetsInAdminHeaderHook;
use WP_Screen;

abstract class AdminCsrfLoaderModule extends Module implements ModuleInterface
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
