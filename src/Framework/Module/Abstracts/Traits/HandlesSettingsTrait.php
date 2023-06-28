<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

use Leonidas\Contracts\Admin\Processing\Setting\SettingCallbackProviderInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingCollectionInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingRegistrarInterface;
use Leonidas\Library\Admin\Processing\Setting\SettingRegistrar;

trait HandlesSettingsTrait
{
    protected function registerSettings(): void
    {
        $this->settingRegistrar()->registerMany(...$this->getSettings()->all());
    }

    protected function settingRegistrar(): SettingRegistrarInterface
    {
        return new SettingRegistrar($this->settingInputManager());
    }

    abstract protected function settingInputManager(): SettingCallbackProviderInterface;

    abstract protected function getSettings(): SettingCollectionInterface;
}
