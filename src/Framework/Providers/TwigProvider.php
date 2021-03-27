<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TwigProvider implements StaticProviderInterface
{
    public static function provide(array $args, ContainerInterface $container): Environment
    {
        $loader = $container->has(LoaderInterface::class)
            ? $container->get(LoaderInterface::class)
            : static::getDefaultLoader($args);

        $twig = new Environment($loader, $args['options']);

        foreach ($args['filters'] as $filter => $function) {
            $twig->addFilter(new TwigFilter($filter, $function));
        }

        foreach ($args['functions'] as $alias => $function) {
            $twig->addFunction(new TwigFunction($alias, $function));
        }

        return $twig;
    }

    protected static function getDefaultLoader(array $args): LoaderInterface
    {
        return new FilesystemLoader($args['paths'], $args['root'] ?? null);
    }
}
