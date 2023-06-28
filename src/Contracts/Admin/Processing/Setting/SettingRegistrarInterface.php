<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

interface SettingRegistrarInterface
{
    public function registerOne(SettingInterface $setting);

    public function registerMany(SettingInterface ...$settings);
}
