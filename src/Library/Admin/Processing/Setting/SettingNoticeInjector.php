<?php

namespace Leonidas\Library\Admin\Processing\Setting;

use Leonidas\Contracts\Admin\Processing\Setting\SettingInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingNoticeInjectorInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingNoticeInterface;

class SettingNoticeInjector implements SettingNoticeInjectorInterface
{
    public function inject(SettingInterface $setting, SettingNoticeInterface $notice): void
    {
        add_settings_error(
            $setting->getOptionName(),
            $notice->getId(),
            $notice->getMessage(),
            $notice->getType()
        );
    }
}
