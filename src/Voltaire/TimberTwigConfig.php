<?php

namespace WebTheory\Voltaire;

use Twig\TwigFilter;
use Twig\TwigFunction;

class TimberTwigConfig
{
    /**
     * @var array
     */
    protected $config;

    /**
     *
     */
    protected function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     *
     */
    protected function hook()
    {
        add_filter('timber/twig', [$this, 'config'], PHP_INT_MAX, 1);

        return $this;
    }

    /**
     *
     */
    public function config($twig)
    {
        $extra = $this->config;

        // functions
        foreach ($extra['functions'] as $alias => $original) {

            $alias = is_string($alias) ? $alias : $original;

            $twig->addFunction(new TwigFunction($alias, $original));
        }

        // filters
        foreach ($extra['filters'] as $filter => $function) {

            $filter = is_string($filter) ? $filter : $function;

            $twig->addFilter(new TwigFilter($filter, $function));
        }

        return $twig;
    }

    /**
     *
     */
    public static function set(array $config)
    {
        return (new static($config))->hook();
    }
}
