<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

use Leonidas\Contracts\Admin\Component\SettingsField\SettingsFieldCollectionInterface;
use Leonidas\Contracts\Admin\Registrar\SettingsFieldRegistrarInterface;
use Psr\Http\Message\ServerRequestInterface;

trait HandlesSettingsFieldsTrait
{
    use AbstractModuleTraitTrait;

    protected function registerSettingsFields(ServerRequestInterface $request)
    {
        $this->settingsFieldRegistrar()->registerMany(
            $this->getSettingsFields(),
            $request
        );
    }

    abstract protected function settingsFieldRegistrar(): SettingsFieldRegistrarInterface;

    abstract protected function getSettingsFields(): SettingsFieldCollectionInterface;
}
