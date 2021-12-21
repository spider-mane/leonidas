<?php

use League\Container\Container;
use League\Container\Definition\DefinitionInterface;
use Leonidas\Contracts\Container\StaticProviderInterface;
use WebTheory\Config\Config;

defined('ABSPATH') || exit;

# instantiate container
$container = new Container();

# provide root directory
$container->addShared('root', function () {
    return dirname(__DIR__, 1);
});

# register config
$container->addShared('config', function () use ($container) {
    return new Config($container->get('root') . '/config');
});

# register services from config
foreach ($container->get('config')->get('container.services', []) as $service) {
    /** @var StaticProviderInterface $provider */
    /** @var DefinitionInterface $service */

    $id       = $service['id'];
    $provider = $service['provider'];
    $args     = $service['args'] ?? [];
    $shared   = $service['shared'] ?? false;
    $tags     = $service['tags'] ?? [];

    $add = $shared ? 'addShared' : 'add';
    $service = $container->$add($id, fn () => $provider::provide($args, $container));

    array_map([$service, 'addTag'], $tags);
}

# register service providers
array_map(
    [$container, 'addServiceProvider'],
    $container->get('config')->get('container.providers', [])
);

# return bootstrapped container
return $container;
