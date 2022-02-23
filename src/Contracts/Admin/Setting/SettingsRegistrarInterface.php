<?php

namespace Leonidas\Contracts\Admin\Setting;

interface SettingsRegistrarInterface
{
    public function registerOne(SettingInterface $setting);

    public function registerMany(SettingInterface ...$settings);
}
