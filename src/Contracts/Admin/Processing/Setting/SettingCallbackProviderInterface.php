<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

interface SettingCallbackProviderInterface
{
    public function getProcessingCallback(SettingInterface $setting): callable;
}
