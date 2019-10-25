<?php

namespace WebTheory\GuctilityBelt;

use Twig\TwigFilter;
use Twig\Environment;
use Twig\TwigFunction;

class TwigConfig
{
    /**
     * @var Environment
     */
    protected $twigInstance;

    /**
     *
     */
    public function __construct(Environment $twigInstance)
    {
        $this->twigInstance = $twigInstance;
    }

    /**
     *
     */
    public function addFilters(array $filters)
    {
        foreach ($filters as $filter => $function) {
            $this->twigInstance->addFilter(new TwigFilter($filter, $function));
        }
    }

    /**
     *
     */
    public function addFunctions(array $functions)
    {
        foreach ($functions as $alias => $function) {
            $this->twigInstance->addFunction(new TwigFunction($alias, $function));
        }
    }
}
