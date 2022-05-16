<?php

namespace Leonidas\Contracts\Admin\Registrar;

use Leonidas\Contracts\Admin\Component\SettingsSection\SettingsSectionCollectionInterface;
use Leonidas\Contracts\Admin\Component\SettingsSection\SettingsSectionInterface;
use Psr\Http\Message\ServerRequestInterface;

interface SettingsSectionRegistrarInterface
{
    public function registerOne(SettingsSectionInterface $section, ServerRequestInterface $request);

    public function registerMany(SettingsSectionCollectionInterface $sections, ServerRequestInterface $request);
}
