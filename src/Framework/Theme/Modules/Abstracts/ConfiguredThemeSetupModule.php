<?php

namespace Leonidas\Framework\Theme\Modules\Abstracts;

use Leonidas\Framework\Theme\Modules\Abstracts\ThemeSetupModule;

abstract class ConfiguredThemeSetupModule extends ThemeSetupModule
{
    public const TEXTDOMAIN_CASCADE = [
        'app.textdomain', 'theme.textdomain', 'plugin.textdomain'
    ];

    protected function textdomain(): string
    {
        return $this->configCascade(static::TEXTDOMAIN_CASCADE);
    }
}
