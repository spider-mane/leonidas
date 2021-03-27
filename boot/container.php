<?php

use League\Container\Container;
use Leonidas\Contracts\Container\ConfigReflectorInterface;
use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Framework\ConfigReflector;
use Leonidas\Framework\Providers\ConfigProvider;

defined('ABSPATH') || exit;

# instantiate container
$container = new Container();

# add root directory for services that need it
$container->share('root', function () {
    return dirname(__FILE__, 1);
});

# register config
$container->share('config', function () use ($container) {
    return ConfigProvider::provide([
        'values' => $container->get('root') . '/config',
    ], $container);
});

# register entries from config
$staticProvider = StaticProviderInterface::class;
$configReflector = ConfigReflectorInterface::class;
foreach ($container->get('config')->get('app.services', []) as $service) {
    $id = $service['id'];

    /** @var StaticProviderInterface $provider */
    $provider = $service['provider'];
    if (!class_exists($provider) || !in_array($staticProvider, class_implements($provider))) {
        throw new RuntimeException(
            "\"provider\", specified for {$id} is not an implementation of {$staticProvider}."
        );
    }

    /** @var ConfigReflector $args */
    $args = $service['args'];
    if (!($args instanceof $configReflector)) {
        throw new RuntimeException(
            "\"args\" provided for {$id} is not an instance of {$configReflector}."
        );
    }

    $alias = $service['alias'] ?? null;
    $shared = $service['shared'] ?? false;
    $tags = $service['tags'] ?? [];

    $service = $container->add($id, function () use ($provider, $args, $container) {
        $args = $args->reflect($container->get('config'));

        return $provider::provide($args, $container);
    }, $shared);

    if (!empty($alias)) {
        $service->setAlias($alias);
    }

    array_map([$service, 'addTag'], $tags);
}

# register service providers
array_map(
    [$container, 'addServiceProvider'],
    $container->get('config')->get('app.providers', [])
);

# return bootstrapped container
return $container;
