<?php

namespace Leonidas\Framework\Module\Traits;

use Closure;
use Leonidas\Contracts\Admin\Component\SettingsSection\SettingsSectionCollectionInterface;
use Leonidas\Contracts\Admin\Registrar\SettingsSectionRegistrarInterface;
use Leonidas\Library\Admin\Registrar\SettingsSectionRegistrar;
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

    protected function renderSettingsSection(array $section): void
    {
        $request = $this->getServerRequest()->withAttribute('section', $section);

        echo $this->getSettingsSections()
            ->get($section['id'])
            ->renderComponent($request);
    }

    protected function settingsSectionRegistrar(): SettingsSectionRegistrarInterface
    {
        return new SettingsSectionRegistrar(
            Closure::fromCallable([$this, 'renderSettingsSection'])
        );
    }

    abstract protected function getSettingsSections(): SettingsSectionCollectionInterface;
}
