<?php

namespace Leonidas\Framework\Theme\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Theme\Modules\Abstracts\TemplateRouterModule;

class TemplateRouter extends TemplateRouterModule
{
    public const TEMPLATE_PATH_CASCADE = [
        'view.templates.path', 'view.templates'
    ];

    protected function templateDirectory(): string
    {
        return $this->configCascade(static::TEMPLATE_PATH_CASCADE);
    }
}
