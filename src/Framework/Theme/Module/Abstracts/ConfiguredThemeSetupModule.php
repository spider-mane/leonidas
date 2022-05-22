<?php

namespace Leonidas\Framework\Theme\Module\Abstracts;

use Leonidas\Contracts\Extension\ModuleInterface;

abstract class ConfiguredThemeSetupModule extends ThemeSetupModule implements ModuleInterface
{
    public const TEXTDOMAIN_IDENTIFIER = 'app.textdomain';

    protected function textdomain(): string
    {
        return $this->getConfig(static::TEXTDOMAIN_IDENTIFIER, '');
    }
}
