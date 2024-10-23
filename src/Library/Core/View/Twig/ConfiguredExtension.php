<?php

namespace Leonidas\Library\Core\View\Twig;

use Twig\Extension\ExtensionInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

class ConfiguredExtension implements ExtensionInterface
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getTokenParsers(): array
    {
        return array_map(
            fn ($parser) => new $parser(),
            $this->get('token_parsers')
        );
    }

    public function getNodeVisitors(): array
    {
        return array_map(
            fn ($visitor) => new $visitor(),
            $this->get('node_visitors')
        );
    }

    /**
     * @link https://twig.symfony.com/doc/3.x/advanced.html#filters
     */
    public function getFilters(): array
    {
        $filters = [];

        foreach ($this->get('filters') as $filter => $callable) {
            $this->resolveCallableArgs($filter, $callable, $options);

            $filters[] = new TwigFilter($filter, $callable, $options);
        }

        return $filters;
    }

    public function getTests(): array
    {
        $tests = [];

        foreach ($this->get('tests') as $test => $callable) {
            $this->resolveCallableArgs($test, $callable, $options);

            $tests[] = new TwigTest($test, $callable, $options);
        }

        return $tests;
    }

    /**
     * @link https://twig.symfony.com/doc/3.x/advanced.html#functions
     */
    public function getFunctions(): array
    {
        $functions = [];

        foreach ($this->get('functions') as $function => $callable) {
            $this->resolveCallableArgs($function, $callable, $options);

            $functions[] = new TwigFunction($function, $callable, $options);
        }

        return $functions;
    }

    public function getOperators()
    {
        $operators = $this->get('operators');

        return [$operators['unary'] ?? [], $operators['binary'] ?? []];
    }

    protected function get(string $key): array
    {
        return $this->config[$key] ?? [];
    }

    /**
     * Converts arguments into values suitable for construction of
     * Twig\TwigFunction and Twig\TwigFilter objects.
     *
     * @param int|string $name Must be derived from the definition key/index. If
     * int and $argument is resolved as string, it will inherit that value.
     *
     * @param callable|array $callable May either be the callable to use or an
     * array containing 'function' and/or 'options' keys. If the latter, will be
     * resolved to callable|null via 'function' entry.
     *
     * @param mixed $options Should be null variable on entry. Value will be
     * resolved from $argument['options'] or as an empty array if $argument is
     * of type callable.
     */
    protected function resolveCallableArgs(&$name, &$callable, &$options): void
    {
        $options = [];

        if (is_array($callable) && !is_callable($callable)) {
            $options = $callable['options'];
            $callable = $callable['function'];
        } elseif (is_int($name) && is_string($callable)) {
            $name = $callable;
        }
    }
}
