<?php

use League\Container\Container;
use Leonidas\Contracts\Container\StaticProviderInterface;
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
foreach ($config->get('app.services', []) as $service) {

    # extract service values
    $id     = $service['id'];
    $alias  = $service['alias'] ?? '';
    $tags   = $service['tags'] ?? [];
    $shared = $service['shared'] ?? null;
    $args   = $service['args'] ?? [];

    /** @var StaticProviderInterface $provider */
    $provider = $service['provider'];

    # register and configure service
    $service = $container->add($id, fn () => $provider::provide(
        $container,
        $args
    ));

    if (null !== $shared) {
        $service->setShared($shared);
    }

    if (!empty($alias)) {
        $service->setAlias($alias);
    }

    array_map([$service, 'addTag'], $tags);
}

# register service providers
foreach ($config->get('container.providers', []) as $provider) {
    $container->addServiceProvider(new $provider);
}

# return bootstrapped container
return $container;
