<?php

namespace Leonidas\Framework\Module\Abstracts;

use Leonidas\Contracts\Admin\Processing\Setting\SettingCollectionInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Abstracts\MustBeInitiatedContextuallyTrait;
use Leonidas\Framework\Module\Abstracts\Traits\HandlesSettingsTrait;
use Leonidas\Hooks\TargetsAdminInitHook;

abstract class SettingsModule extends Module implements ModuleInterface
{
    use HandlesSettingsTrait;
    use MustBeInitiatedContextuallyTrait;
    use TargetsAdminInitHook;

    protected SettingCollectionInterface $settings;

    protected function getSettings(): SettingCollectionInterface
    {
        return $this->settings;
    }

    public function hook(): void
    {
        $this->targetAdminInitHook();
    }

    protected function doAdminInitAction(): void
    {
        $this->init('admin_init');

        $this->registerSettings();
    }

    protected function adminInitRequiredProperties(): array
    {
        return ['settings'];
    }

    abstract protected function settings(): SettingCollectionInterface;
}
