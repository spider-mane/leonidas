<?php

namespace Leonidas\Library\Admin\Processing\Setting;

use Leonidas\Contracts\Admin\Processing\Setting\SettingCapsuleInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingNoticeInterface;
use WebTheory\Saveyour\Contracts\Formatting\InputFormatterInterface;
use WebTheory\Saveyour\Contracts\Validation\ValidatorInterface;
use WebTheory\Saveyour\Formatting\LazyInputFormatter;
use WebTheory\Saveyour\Validation\PermissiveValidator;

class EmptySettingCapsule implements SettingCapsuleInterface
{
    public function validator(SettingInterface $setting): ValidatorInterface
    {
        return new PermissiveValidator();
    }

    public function formatter(SettingInterface $setting): InputFormatterInterface
    {
        return new LazyInputFormatter();
    }

    public function notice(string $event, SettingInterface $setting): ?SettingNoticeInterface
    {
        return null;
    }
}
