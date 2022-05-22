<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\System\Setting\SettingCollectionInterface;
use Leonidas\Framework\Module\Abstracts\FluentlySetsPropertiesTrait;
use Leonidas\Framework\Module\Abstracts\HandlesSettingsTrait;
use Leonidas\Hooks\TargetsAdminInitHook;

abstract class AbstractSettingsModuleInterface extends AbstractModule implements ModuleInterface
{
    use FluentlySetsPropertiesTrait;
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
