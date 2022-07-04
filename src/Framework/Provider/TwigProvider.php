<?php

declare(strict_types=1);

namespace Leonidas\Framework\Provider;

use Leonidas\Library\Core\Abstracts\ConvertsCaseTrait;
use Leonidas\Library\Core\View\Twig\ConfiguredExtension;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

class TwigProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    use ConvertsCaseTrait;

    protected const ADDITIONS = [
        'extensions',
        'globals',
        'runtime_loaders',
    ];

    public function create(ContainerInterface $container, array $args = []): Environment
    {
        $loaderService = $args['$loader'] ?? LoaderInterface::class;
        $loader = $this->fetch($loaderService, $container)
            ?? $this->getDefaultLoader($args);

        $env = new Environment($loader, $args['options'] ?? []);

        $env->addExtension(new ConfiguredExtension($args));

        foreach (static::ADDITIONS as $addition) {
            if (!empty($values = $args[$addition] ?? [])) {
                $this->{$this->prefixPascal('add', $addition)}($env, $values);
            }
        }

        return $env;
    }

    protected function getDefaultLoader(array $args): LoaderInterface
    {
        if (!array_is_list($paths = $args['paths'])) {
            $main = FilesystemLoader::MAIN_NAMESPACE;
            $namespaces = $paths;
            $paths = $paths['@main'] ?? $paths[$main] ?? [];

            unset($namespaces['@main'], $namespaces[$main]);
        }

        $loader = new FilesystemLoader($paths, $args['root']);

        foreach ($namespaces ?? [] as $namespace => $paths) {
            $loader->setPaths($paths, $namespace);
        }

        return $loader;
    }

    protected function addExtensions(Environment $env, array $extensions): void
    {
        foreach ($extensions as $extension) {
            $env->addExtension(new $extension());
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

    protected function addRuntimeLoaders(Environment $env, array $runtimeLoaders): void
    {
        foreach ($runtimeLoaders as $loader) {
            $env->addRuntimeLoader(new $loader());
        }
    }
}
