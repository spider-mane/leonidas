<?php

namespace Leonidas\Framework\Theme\Modules;

use Leonidas\Framework\Theme\Modules\Abstracts\TimberEnvironmentModule;
use Twig\Environment;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TimberEnvironment extends TimberEnvironmentModule
{
    public const TIMBER_TWIG_CONFIG_KEYS = [
        'view.timber.twig', 'view.twig', 'twig'
    ];

    protected function configure(Environment $twig): Environment
    {
        $extra = $this->configCascade(static::TIMBER_TWIG_CONFIG_KEYS);

        foreach ($extra['functions'] as $alias => $original) {
            $alias = is_string($alias) ? $alias : $original;

            $twig->addFunction(new TwigFunction($alias, $original));
        }

        foreach ($extra['filters'] as $filter => $function) {
            $filter = is_string($filter) ? $filter : $function;

            $twig->addFilter(new TwigFilter($filter, $function));
        }

        return $twig;
    }
}
