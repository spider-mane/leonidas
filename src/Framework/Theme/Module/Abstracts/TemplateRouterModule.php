<?php

namespace Leonidas\Framework\Theme\Module\Abstracts;

use Closure;
use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\Abstracts\Module;
use Leonidas\Framework\Theme\Theme;

abstract class TemplateRouterModule extends Module implements ModuleInterface
{
    public function hook(): void
    {
        foreach (Theme::TEMPLATE_TYPES as $type) {
            add_filter(
                "{$type}_template_hierarchy",
                $this->getFilterCallback(),
                PHP_INT_MAX,
                1
            );
        }
    }

    protected function getFilterCallback(): Closure
    {
        return Closure::fromCallable([$this, 'redirect']);
    }

    protected function redirect($templates)
    {
        foreach ((array) $templates as $i => $template) {
            $templates[$i] = $this->templateDirectory() . '/' . $template;
        }

        return $templates;
    }

    abstract protected function templateDirectory(): string;
}
