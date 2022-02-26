<?php

namespace Leonidas\Framework\Modules;

use Framework\Modules\Traits\FluentlySetsPropertiesTrait;
use Leonidas\Contracts\Admin\Setting\SettingCollectionInterface;
use Leonidas\Contracts\Admin\Setting\SettingRegistrarInterface;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\Traits\HandlesSettingsTrait;
use Leonidas\Traits\Hooks\TargetsAdminInitHook;

abstract class AbstractSettingsModuleInterface extends AbstractModule implements ModuleInterface
{
    use HandlesSettingsTrait;
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

    protected function initiationContexts(): array
    {
        return [
            'admin_init' => $this->adminInitRequirements(),
        ];
    }

    protected function adminInitRequirements(): array
    {
        return ['settings'];
    }

    abstract protected function settings(): SettingCollectionInterface;
}
