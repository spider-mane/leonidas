<?php

namespace Leonidas\Library\Core\View\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;
use WebTheory\WpTest\Skyhooks\SkyHooks;

class SkyHooksExtension extends AbstractExtension implements ExtensionInterface
{
    public function getFunctions()
    {
        $options = [
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
}
