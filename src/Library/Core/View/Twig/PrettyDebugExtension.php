<?php

namespace Leonidas\Library\Core\View\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Template;
use Twig\TemplateWrapper;
use Twig\TwigFunction;

class PrettyDebugExtension extends AbstractExtension implements ExtensionInterface
{
    public function getFunctions()
    {
        $options = [
            'is_safe' => $this->isHtmlSafeDumpOutput() ? ['html'] : [],
            'needs_context' => true,
            'needs_environment' => true,
            'is_variadic' => true,
        ];

        return array_map(
            fn ($function) => new TwigFunction($function, [$this, $function], $options),
            ['dump', 'dd']
        );
    }

    public function dump(Environment $env, $context, ...$vars)
    {
        return $this->call('dump', $env, $context, ...$vars);
    }

    public function dd(Environment $env, $context, ...$vars)
    {
        return $this->call('dd', $env, $context, ...$vars);
    }

    protected function isHtmlSafeDumpOutput()
    {
        return extension_loaded('xdebug')
            // false means that it was not set (and the default is on) or it explicitly enabled
            && (false === ini_get('xdebug.overload_var_dump') || ini_get('xdebug.overload_var_dump'))
            // false means that it was not set (and the default is on) or it explicitly enabled
            // xdebug.overload_var_dump produces HTML only when html_errors is also enabled
            && (false === ini_get('html_errors') || ini_get('html_errors'))
            || 'cli' === PHP_SAPI;
    }

    protected function call(callable $function, Environment $env, $context, ...$vars)
    {
        if (!$env->isDebug()) {
            return;
        }

        ob_start();

        $vars ? $function(...$vars) : $function($this->filterContext($context));

        return ob_get_clean();
    }

    protected function filterContext($context): array
    {
        $vars = [];

        foreach ($context as $key => $value) {
            if (!$value instanceof Template && !$value instanceof TemplateWrapper) {
                $vars[$key] = $value;
            }
        }

        return $vars;
    }
}
