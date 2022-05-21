<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\Traits\SettingsPageModuleTrait;

abstract class AbstractSettingsInteriorPageModule extends AbstractInteriorPageModule implements ModuleInterface
{
    use SettingsPageModuleTrait;
}
