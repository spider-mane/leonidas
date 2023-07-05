<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

use Leonidas\Contracts\Admin\Component\SettingsSection\SettingsSectionCollectionInterface;
use Leonidas\Contracts\Admin\Registrar\SettingsSectionRegistrarInterface;
use Psr\Http\Message\ServerRequestInterface;

trait HandlesSettingsSectionsTrait
{
    use AbstractModuleTraitTrait;

    protected function registerSettingsSections(ServerRequestInterface $request): void
    {
        $this->settingsSectionRegistrar()->registerMany(
            $this->getSettingsSections(),
            $request
        );
    }

    abstract protected function settingsSectionRegistrar(): SettingsSectionRegistrarInterface;

    abstract protected function getSettingsSections(): SettingsSectionCollectionInterface;
}
