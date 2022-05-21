<?php

namespace Leonidas\Framework\Module\Traits;

use Leonidas\Contracts\System\Setting\SettingCollectionInterface;
use Leonidas\Contracts\System\Setting\SettingRegistrarInterface;
use Leonidas\Library\System\Setting\SettingRegistrar;

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
