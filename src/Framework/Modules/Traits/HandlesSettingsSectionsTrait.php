<?php

namespace Leonidas\Framework\Modules\Traits;

use Closure;
use Leonidas\Contracts\Admin\Component\SettingsSectionCollectionInterface;
use Leonidas\Contracts\Admin\Component\SettingsSectionRegistrarInterface;
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
