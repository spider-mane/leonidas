<?php

namespace Leonidas\Contracts\Admin\Processing\Setting;

use WebTheory\Saveyour\Contracts\Formatting\InputFormatterInterface;
use WebTheory\Saveyour\Contracts\Validation\ValidatorInterface;

interface SettingCapsuleInterface
{
    public function validator(SettingInterface $setting): ValidatorInterface;

    public function formatter(SettingInterface $setting): InputFormatterInterface;

    public function notice(string $event, SettingInterface $setting): ?SettingNoticeInterface;
}
