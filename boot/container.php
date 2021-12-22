<?php

use League\Container\Container;
use WebTheory\Config\Config;

defined('ABSPATH') || exit;

# instantiate container
$container = new Container();

# register root directory
$root = $container->addShared('root', dirname(__DIR__, 1))->getConcrete();

# register config
$config = $container
    ->addShared('config', new Config("$root/config"))
    ->getConcrete();

# register services from config
foreach ($config->get('container.services', []) as $service) {

    # extract service values
    $id       = $service['id'];
    $provider = $service['provider'];
    $args     = $service['args'] ?? [];
    $shared   = $service['shared'] ?? false;
    $tags     = $service['tags'] ?? [];

    # register and configure service
    $add = $shared ? 'addShared' : 'add';
    $service = $container->$add($id, fn () => $provider::provide($args, $container));

    array_map([$service, 'addTag'], $tags);
}

# register service providers
foreach ($config->get('container.providers', []) as $provider) {
    $container->addServiceProvider(new $provider);
}

# return bootstrapped container
return $container;
