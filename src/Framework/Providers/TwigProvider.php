<?php

declare(strict_types=1);

namespace Leonidas\Framework\Providers;

use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;
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
    use ConvertsCaseTrait;

    protected const ADDITIONS = [
        'extensions',
        'filters',
        'functions',
        'globals',
        'node_visitors',
        'runtime_loaders',
        'tests',
        'token_parsers',
    ];

    public function create(ContainerInterface $container, array $args = []): Environment
    {
        $loaderService = $args['$loader'] ?? LoaderInterface::class;

        $loader = $container->has($loaderService)
            ? $container->get($loaderService)
            : $this->defaultLoader($args);

        $env = new Environment($loader, $args['options']);

        foreach (static::ADDITIONS as $addition) {
            if (!empty($values = $args[$addition])) {
                $this->{$this->prefixPascal('add', $addition)}($env, $values);
            }
        }

        return $env;
    }

    protected function defaultLoader(array $args): LoaderInterface
    {
        return new FilesystemLoader($args['paths'], $args['root'] ?? null);
    }

    /**
     * Converts arguments into values suitable for construction of
     * Twig\TwigFunction and Twig\TwigFilter objects.
     *
     * @param int|string $name Must be derived from the definition key/index. If
     * int and $argument is resolved as string, it will inherit that value.
     *
     * @param callable|array $argument May either be the callable to use or an
     * array containing 'function' and/or 'options' keys. If the latter, will be
     * resolved to callable|null via 'function' entry.
     *
     * @param mixed $options Should be null variable on entry. Value will be
     * resolved from $argument['options'] or as an empty array if $argument is
     * of type callable.
     */
    protected function resolveCallableArgs(&$name, &$argument, &$options): void
    {
        $options = [];

        if (is_array($argument) && !is_callable($argument)) {
            $argument = $argument['function'];
            $options = $argument['options'];
        }

        if (is_int($name) && is_string($argument)) {
            $name = $argument;
        }
    }

    /**
     * @link https://twig.symfony.com/doc/3.x/advanced.html#functions
     */
    protected function addFunctions(Environment $env, array $functions): void
    {
        foreach ($functions as $function => $argument) {
            $this->resolveCallableArgs($function, $argument, $options);
            $env->addFunction(new TwigFunction($function, $argument, $options));
        }
    }

    /**
     * @link https://twig.symfony.com/doc/3.x/advanced.html#filters
     */
    protected function addFilters(Environment $env, array $filters): void
    {
        foreach ($filters as $filter => $argument) {
            $this->resolveCallableArgs($filter, $argument, $options);
            $env->addFilter(new TwigFilter($filter, $argument, $options));
        }
    }

    /**
     * @link https://twig.symfony.com/doc/3.x/advanced.html#globals
     */
    protected function addGlobals(Environment $env, array $globals): void
    {
        foreach ($globals as $name => $value) {
            $env->addGlobal($name, $value);
        }
    }

    protected function addTokenParsers(Environment $env, array $tokenParsers): void
    {
        foreach ($tokenParsers as $parser) {
            $env->addTokenParser(new $parser());
        }
    }

    protected function addNodeVisitors(Environment $env, array $nodeVisitors): void
    {
        foreach ($nodeVisitors as $visitor) {
            $env->addNodeVisitor(new $visitor());
        }
    }

    protected function addRuntimeLoaders(Environment $env, array $runtimeLoaders): void
    {
        foreach ($runtimeLoaders as $loader) {
            $env->addRuntimeLoader(new $loader());
        }
    }

    protected function addTests(Environment $env, array $tests): void
    {
        foreach ($tests as $test) {
            $env->addTest(new $test());
        }
    }

    protected function addExtensions(Environment $env, array $extensions): void
    {
        foreach ($extensions as $extension) {
            $env->addExtension(new $extension());
        }
    }
}
