<?php

use League\Container\Container;
use Leonidas\Contracts\Admin\Components\AdminNoticeInterface;
use Leonidas\Contracts\Container\ConfigReflectorInterface;
use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Framework\ConfigReflector;
use Leonidas\Framework\Providers\AdminNoticeCollectionLoaderProvider;
use Leonidas\Framework\Providers\ConfigProvider;
use Leonidas\Framework\Providers\TwigProvider;
use Leonidas\Library\Admin\Loaders\AdminNoticeCollectionLoader;
use Leonidas\Library\Admin\Loaders\AdminNoticeCollectionLoaderInterface;
use Noodlehaus\ConfigInterface;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;
use WebTheory\GuctilityBelt\Config;

use function Leonidas\Framework\Providers\provide_admin_notice_collection_loader;
use function Leonidas\Framework\Providers\provide_config;
use function Leonidas\Framework\Providers\provide_twig_environment;

defined('ABSPATH') || exit;

// instantiate container
$container = new Container();

// add root directory for services that need it
$container->share('root', function () {
    return dirname(__FILE__, 1);
});

// register config
$container->share('config', function () use ($container) {
    return ConfigProvider::provide([
        'values' => $container->get('root') . '/config',
    ], $container);
});

// register entries from config
$staticProvider = StaticProviderInterface::class;
$configReflector = ConfigReflectorInterface::class;
$entries = $container->get('config')->get('app.definitions');

foreach ($entries as $entry) {
    $name = $entry['name'];

    /** @var StaticProviderInterface $provider */
    $provider = $entry['provider'];
    if (!class_exists($provider) || !in_array($staticProvider, class_implements($provider))) {
        throw new RuntimeException(
            "{$provider}, specified for {$name} is not an implementation of {$staticProvider}."
        );
    }

    /** @var ConfigReflector $args */
    $args = $entry['args'];
    if (!($args instanceof $configReflector)) {
        throw new RuntimeException(
            "\"args\" provided for {$name} is not an instance of {$configReflector}."
        );
    }

    // specify values particular to DI container
    $alias = $entry['alias'] ?? null;
    $shared = $entry['shared'] ?? false;

    // continue building container
    $entry = $container->add($name, function () use ($provider, $args, $container) {
        $args = $args->reflect($container->get('config'));

        return $provider::provide($args, $container);
    })->setShared($shared);

    if (!empty($alias)) {
        $entry->setAlias($alias);
    }
}

// register service providers
array_map(
    [$container, 'addServiceProvider'],
    $container->get('config')->get('app.providers', [])
);

// return bootstrapped container
return $container;
