<?php

namespace Leonidas\Framework\Modules\Traits;

use Leonidas\Contracts\Admin\Components\SettingsFieldCollectionInterface;
use Leonidas\Contracts\Admin\Components\SettingsSectionCollectionInterface;
use Leonidas\Contracts\Admin\Setting\SettingCollectionInterface;
use Leonidas\Hooks\TargetsAdminInitHook;

trait HandlesSettingsApiTrait
{
    use AbstractModuleTraitTrait;
    use FluentlySetsPropertiesTrait;
    use HandlesSettingsFieldsTrait;
    use HandlesSettingsSectionsTrait;
    use HandlesSettingsTrait;
    use TargetsAdminInitHook;

    protected SettingCollectionInterface $settings;

    protected SettingsSectionCollectionInterface $settingsSections;

    protected SettingsFieldCollectionInterface $settingsFields;

    protected function getSettings(): SettingCollectionInterface
    {
        return $this->settings;
    }

    protected function getSettingsFields(): SettingsFieldCollectionInterface
    {
        return $this->settingsFields;
    }

    protected function getSettingsSections(): SettingsSectionCollectionInterface
    {
        return $this->settingsSections;
    }

    protected function doAdminInitAction(): void
    {
        $this->init('admin_init');

        $request = $this->getServerRequest();

        $this->registerSettings();
        $this->registerSettingsSections($request);
        $this->registerSettingsFields($request);
    }

    protected function settingsApiAdminInitProperties(): array
    {
        return ['settings', 'settingsSections', 'settingsFields'];
    }

    abstract protected function settings(): SettingCollectionInterface;

    abstract protected function settingsSections(): SettingsSectionCollectionInterface;

    abstract protected function settingsFields(): SettingsFieldCollectionInterface;
}
