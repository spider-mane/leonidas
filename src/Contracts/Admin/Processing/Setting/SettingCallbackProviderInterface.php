<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

interface SettingCallbackProviderInterface
{
    /**
     * @return callable(mixed $input): mixed
     */
    public function getProcessingCallback(SettingInterface $setting): callable;
}
