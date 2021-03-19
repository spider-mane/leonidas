<?php

use League\Container\Container;
use Leonidas\Contracts\Admin\Components\AdminNoticeInterface;
use Leonidas\Library\Admin\Loaders\AdminNoticeCollectionLoader;
use Noodlehaus\ConfigInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;
use WebTheory\GuctilityBelt\Config;

$root = dirname(__DIR__);
$container = new Container();

// register config
$container->share(ConfigInterface::class, function () {
    return new Config('../config');
})->setAlias('config');

// register twig environment
$container->share(Environment::class, function () use ($container, $root) {
    $config = $container->get('config')->get('twig');
    $loader = new FilesystemLoader($config['paths'], $root);
    $twig = new Environment($loader, $config['options']);

    foreach ($config['filters'] as $filter => $function) {
        $twig->addFilter(new TwigFilter($filter, $function));
    }

    foreach ($config['functions'] as $alias => $function) {
        $twig->addFunction(new TwigFunction($alias, $function));
    }

    return $twig;
})->setAlias('twig');

// register admin notice loader
$container->share(AdminNoticeInterface::class, function () use ($container) {
    $prefix = $container->get('config')->get('plugin.prefix.extended');
    $loader = new AdminNoticeCollectionLoader("{$prefix}.adminNotices");
    $loader->hook();

    return $loader;
})->setAlias('notice_loader');

// register service providers
array_map(
    [$container, 'addServiceProvider'],
    $container->get('config')->get('app.providers', [])
);

// return bootstrapped container
return $container;
