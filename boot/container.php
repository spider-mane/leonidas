<?php

use League\Container\Container;
use Leonidas\Contracts\Container\StaticProviderInterface;
use WebTheory\Config\Config;

defined('ABSPATH') || exit;

# instantiate container
$container = new Container();

# provide root directory
$container->share('root', function () {
    return dirname(__DIR__, 1);
});

# register config
$container->share('config', function () use ($container) {
    return new Config($container->get('root') . '/config');
});

# register services from config
foreach ($container->get('config')->get('container.services', []) as $service) {
    /** @var StaticProviderInterface $provider */

    # extract service values
    $id       = $service['id'];
    $provider = $service['provider'];
    $args     = $service['args'] ?? [];
    $shared   = $service['shared'] ?? false;
    $tags     = $service['tags'] ?? [];

    # register and configure service
    $service = $container->add($id, function () use ($provider, $args, $container) {
        return $provider::provide($args, $container);
    }, $shared);

    array_map([$service, 'addTag'], $tags);
}

# register service providers
array_map(
    [$container, 'addServiceProvider'],
    $container->get('config')->get('container.providers', [])
);

# return bootstrapped container
return $container;
