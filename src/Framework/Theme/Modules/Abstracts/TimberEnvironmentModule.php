<?php

namespace Leonidas\Framework\Theme\Modules\Abstracts;

use Closure;
use Leonidas\Framework\Modules\AbstractModule;
use Twig\Environment;
use Twig\TwigFilter;
use Twig\TwigFunction;

abstract class TimberEnvironmentModule extends AbstractModule
{
    public function hook(): void
    {
        add_filter('timber/twig', Closure::fromCallable([$this, 'configure']));
    }

    abstract protected function configure(Environment $twig): Environment;
}
