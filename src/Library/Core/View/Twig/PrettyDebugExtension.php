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
