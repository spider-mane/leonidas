<?php

namespace Leonidas\Contracts\System\Setting;

interface SettingRegistrarInterface
{
    public function registerOne(SettingInterface $setting);

    public function registerMany(SettingInterface ...$settings);
}
