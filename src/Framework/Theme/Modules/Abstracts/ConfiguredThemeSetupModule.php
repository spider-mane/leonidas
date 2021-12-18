<?php

namespace Leonidas\Framework\Theme\Modules;

use Leonidas\Framework\Theme\Modules\Abstracts\ThemeSetupModule;

abstract class ConfiguredThemeSetupModule extends ThemeSetupModule
{
    public const TEXTDOMAIN_CONFIG_KEYS = [
        'app.textdomain', 'theme.textdomain', 'plugin.textdomain'
    ];

    protected function textdomain(): string
    {
        return $this->configCascade(static::TEXTDOMAIN_CONFIG_KEYS);
    }
}
