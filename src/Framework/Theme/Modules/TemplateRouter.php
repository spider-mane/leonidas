<?php

namespace Leonidas\Framework\Theme\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Theme\Modules\Abstracts\TemplateRouterModule;

class TemplateRouter extends TemplateRouterModule
{
    public const TEMPLATE_PATH_CONFIG_KEYS = [
        'view.templates.path'
    ];

    protected function templateDirectory(): string
    {
        return $this->configCascade(static::TEMPLATE_PATH_CONFIG_KEYS);
    }
}
