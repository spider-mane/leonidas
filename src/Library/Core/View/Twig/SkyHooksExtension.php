<?php

namespace Leonidas\Library\Core\View\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;
use WebTheory\WpTest\SkyHooks;

class SkyHooksExtension extends AbstractExtension implements ExtensionInterface
{
    public function getFunctions()
    {
        $options = [
            'is_safe' => $this->isHtmlSafeDumpOutput() ? ['html'] : [],
            'needs_environment' => true,
        ];

        return [
            new TwigFunction('hooks', [$this, 'hooks'], $options),
        ];
    }

    public function hooks(Environment $env, bool $exit = true)
    {
        if (!$env->isDebug()) {
            return;
        }

        $exit ? SkyHooks::stop() : SkyHooks::dump();
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
}
