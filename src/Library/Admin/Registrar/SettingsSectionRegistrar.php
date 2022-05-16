<?php

namespace Leonidas\Library\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\SettingsSection\SettingsSectionCollectionInterface;
use Leonidas\Contracts\Admin\Component\SettingsSection\SettingsSectionInterface;
use Leonidas\Contracts\Admin\Registrar\SettingsSectionRegistrarInterface;
use Leonidas\Library\Admin\Registrar\Abstracts\AbstractRegistrar;
use Psr\Http\Message\ServerRequestInterface;

class SettingsSectionRegistrar extends AbstractRegistrar implements SettingsSectionRegistrarInterface
{
    public function registerOne(SettingsSectionInterface $section, ServerRequestInterface $request)
    {
        if ($section->shouldBeRendered($request)) {
            add_settings_section(
                $section->getId(),
                $section->getTitle(),
                $this->getOutputLoader(),
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
}
