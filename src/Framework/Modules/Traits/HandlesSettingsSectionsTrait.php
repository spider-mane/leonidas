<?php

namespace Leonidas\Framework\Modules\Traits;

use Closure;
use Leonidas\Contracts\Admin\Components\SettingsSectionCollectionInterface;
use Leonidas\Contracts\Admin\Components\SettingsSectionLoaderInterface;
use Leonidas\Library\Admin\Page\SettingsSection\SettingsSectionLoader;
use Psr\Http\Message\ServerRequestInterface;

trait HandlesSettingsSectionsTrait
{
    use AbstractModuleTraitTrait;

    protected function registerSettingsSections(ServerRequestInterface $request): void
    {
        $this->settingsSectionLoader()->registerMany(
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

    protected function settingsSectionLoader(): SettingsSectionLoaderInterface
    {
        return new SettingsSectionLoader(
            Closure::fromCallable([$this, 'renderSettingsSection'])
        );
    }

    abstract protected function getSettingsSections(): SettingsSectionCollectionInterface;
}
