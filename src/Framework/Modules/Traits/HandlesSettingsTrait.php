<?php

namespace Leonidas\Framework\Modules\Traits;

use Leonidas\Contracts\Admin\Setting\SettingCollectionInterface;
use Leonidas\Contracts\Admin\Setting\SettingRegistrarInterface;
use Leonidas\Library\Admin\Setting\SettingRegistrar;

trait HandlesSettingsTrait
{
    protected function registerSettings(): void
    {
        $this->settingRegistrar()->registerMany(...$this->getSettings()->all());
    }

    protected function settingRegistrar(): SettingRegistrarInterface
    {
        return new SettingRegistrar();
    }

    abstract protected function getSettings(): SettingCollectionInterface;
}
