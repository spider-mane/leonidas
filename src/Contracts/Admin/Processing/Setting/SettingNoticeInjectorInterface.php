<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

interface SettingNoticeInjectorInterface
{
    public function inject(SettingInterface $setting, SettingNoticeInterface $notice): void;
}
