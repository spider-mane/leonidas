<?php

namespace Leonidas\Framework\Theme\Module;

use Leonidas\Framework\Theme\Module\Abstracts\ThemeFeaturesModule;

class ThemeFeatures extends ThemeFeaturesModule
{
    protected function features(): array
    {
        return $this->getConfig('features');
    }
}
