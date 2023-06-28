<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

use Leonidas\Contracts\Admin\Component\SettingsField\SettingsFieldCollectionInterface;
use Leonidas\Contracts\Admin\Component\SettingsSection\SettingsSectionCollectionInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingCollectionInterface;
use Leonidas\Framework\Abstracts\MustBeInitiatedContextuallyTrait;

trait HandlesSettingsApiTrait
{
    use AbstractModuleTraitTrait;
    use HandlesSettingsFieldsTrait;
    use HandlesSettingsSectionsTrait;
    use HandlesSettingsTrait;
    use MustBeInitiatedContextuallyTrait;

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

    protected function registerSettingsApi(): void
    {
        $this->init('settings_api_registration');

        $request = $this->getServerRequest();

        $this->registerSettings();
        $this->registerSettingsSections($request);
        $this->registerSettingsFields($request);
    }

    protected function settingsApiRegistrationRequiredProperties(): array
    {
        return ['settings', 'settingsSections', 'settingsFields'];
    }

    abstract protected function settings(): SettingCollectionInterface;

    abstract protected function settingsSections(): SettingsSectionCollectionInterface;

    abstract protected function settingsFields(): SettingsFieldCollectionInterface;
}
