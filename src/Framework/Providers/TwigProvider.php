<?php

namespace Leonidas\Framework\Providers;

use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TwigProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): Environment
    {
        $loaderService = $args['@loader'] ?? LoaderInterface::class;

        $loader = $container->has($loaderService)
            ? $container->get($loaderService)
            : $this->defaultLoader($args);

        $twig = new Environment($loader, $args['options']);

        $this->addFunctions($twig, $args);
        $this->addFilters($twig, $args);
        $this->addGlobals($twig, $args);

        return $twig;
    }

    protected function addFunctions(Environment $twig, array $args)
    {
        foreach ($args['functions'] ?? [] as $alias => $function) {
            $twig->addFunction(new TwigFunction($alias, $function));
        }
    }

    protected function addFilters(Environment $twig, array $args)
    {
        foreach ($args['filters'] ?? [] as $filter => $function) {
            $twig->addFilter(new TwigFilter($filter, $function));
        }
    }

    protected function addGlobals(Environment $twig, array $args)
    {
        foreach ($args['globals'] as $global => $value) {
            $twig->addGlobal($global, $value);
        }
    }

    protected function defaultLoader(array $args): LoaderInterface
    {
        return new FilesystemLoader($args['paths'], $args['root'] ?? null);
    }
}
