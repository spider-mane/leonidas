<?php

namespace Leonidas\Framework\Theme\Modules\Abstracts;

abstract class ConfiguredThemeSetupModule extends ThemeSetupModule
{
    public const TEXTDOMAIN_IDENTIFIER = 'app.textdomain';

    protected function textdomain(): string
    {
        return $this->getConfig(static::TEXTDOMAIN_IDENTIFIER, '');
    }
}
