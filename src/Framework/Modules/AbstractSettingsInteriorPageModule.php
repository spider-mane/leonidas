<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Modules\Traits\SettingsPageModuleTrait;

abstract class AbstractSettingsInteriorPageModule extends AbstractInteriorPageModule implements ModuleInterface
{
    use SettingsPageModuleTrait;
}
