<?php

namespace Leonidas\Framework\Theme\Module;

use Leonidas\Framework\Theme\Module\Abstracts\TemplateRouterModule;

class TemplateRouter extends TemplateRouterModule
{
    public const TEMPLATE_PATH_CASCADE = [
        'view.templates.path', 'view.templates',
    ];

    protected function templateDirectory(): string
    {
        return $this->configCascade(static::TEMPLATE_PATH_CASCADE);
    }
}
