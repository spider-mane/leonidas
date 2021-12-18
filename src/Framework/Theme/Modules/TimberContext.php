<?php

namespace Leonidas\Framework\Theme\Modules;

use Leonidas\Framework\Theme\Modules\Abstracts\TimberContextModule;

class TimberContext extends TimberContextModule
{
    public const TIMBER_CONTEXT_CONFIG_KEYS = [
        'view.timber.context', 'view.twig.context', 'twig.context'
    ];

    protected function file(): string
    {
        return $this->absPath(
            $this->configCascade(static::TIMBER_CONTEXT_CONFIG_KEYS)
        );
    }
}
