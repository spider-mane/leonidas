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
$container->add(ConfigInterface::class, function () {
    return new Config('../config');
})->setAlias('config')->setShared(true);


// register twig environment
$container->add(Environment::class, function () use ($container, $root) {
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
})->setAlias('twig')->setShared(true);


// register admin loader
$container->add(AdminNoticeInterface::class, function () use ($container) {
    $prefix = $container->get('config')->get('plugin.prefix.extended');
    $loader = new AdminNoticeCollectionLoader("{$prefix}.adminNotices");
    $loader->hook();

    return $loader;
})->setAlias('notice_loader')->setShared(true);


// register service providers
$providers = $container->get('config')->get('app.providers', []);

foreach ($providers as $provider) {
    $container->addServiceProvider($provider);
}



// return bootstrapped container
return $container;
