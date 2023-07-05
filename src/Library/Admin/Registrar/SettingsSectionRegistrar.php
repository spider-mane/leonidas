<?php

namespace Leonidas\Library\Admin\Registrar;

use Leonidas\Contracts\Admin\Callback\SettingsSectionCallbackProviderInterface;
use Leonidas\Contracts\Admin\Component\SettingsSection\SettingsSectionCollectionInterface;
use Leonidas\Contracts\Admin\Component\SettingsSection\SettingsSectionInterface;
use Leonidas\Contracts\Admin\Registrar\SettingsSectionRegistrarInterface;
use Psr\Http\Message\ServerRequestInterface;

class SettingsSectionRegistrar implements SettingsSectionRegistrarInterface
{
    public function __construct(protected SettingsSectionCallbackProviderInterface $callbackProvider)
    {
        //
    }

    public function registerOne(SettingsSectionInterface $section, ServerRequestInterface $request)
    {
        if ($section->shouldBeRendered($request)) {
            add_settings_section(
                $section->getId(),
                $section->getTitle(),
                $this->getRenderingCallback($section, $request),
                $section->getPage()
            );
        }
    }

    public function registerMany(SettingsSectionCollectionInterface $sections, ServerRequestInterface $request)
    {
        foreach ($sections->all() as $section) {
            $this->registerOne($section, $request);
        }
    }

    protected function getRenderingCallback(SettingsSectionInterface $section, ServerRequestInterface $request): callable
    {
        return $this->callbackProvider->getRenderingCallback($section, $request);
    }
}
